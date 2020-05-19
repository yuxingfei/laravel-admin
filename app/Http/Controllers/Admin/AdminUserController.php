<?php
/**
 * 后台用户控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use App\Model\Common\Attachment;
use App\Validate\Admin\AdminUserValidate;
use Illuminate\Http\Request;
use App\Model\Admin\AdminRole;
use App\Model\Admin\AdminUser;

class AdminUserController extends AdminBaseController
{

    /**
     * 首页
     *
     * @param Request $request
     * @param AdminUser $model
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:15
     */
    public function index(Request $request, AdminUser $model)
    {
        $param = $request->input();
        $data  = $model->addWhere($param)->paginate($this->admin['per_page']);

        return $this->admin_view('admin.admin_user.index',array_merge(['data'  => $data],$request->query()));
    }

    /**
     * 添加
     *
     * @param Request $request
     * @param AdminUser $model
     * @param AdminUserValidate $validate
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:16
     */
    public function add(Request $request, AdminUser $model, AdminUserValidate $validate)
    {
        if ($request->isMethod('post')) {
            $param           = $request->input();

            $validate_result = $validate->scene('add')->check($param);
            if (!$validate_result) {
                return error($validate->getError());
            }

            $result = $model::create($param);

            $url = URL_BACK;
            if (isset($param['_create']) && $param['_create'] == 1) {
                $url = URL_RELOAD;
            }

            return $result ? success('添加成功', $url) : error();
        }

        $role = AdminRole::all();

        return $this->admin_view('admin.admin_user.add',[
            'role' => $role
        ]);
    }

    /**
     * 修改
     *
     * @param $id
     * @param Request $request
     * @param AdminUser $model
     * @param AdminUserValidate $validate
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:16
     */
    public function edit($id, Request $request, AdminUser $model, AdminUserValidate $validate)
    {
        $data = $model::find($id);

        if ($request->isMethod('post')) {
            $param           = $request->input();
            $validate_result = $validate->scene('edit')->check($param);
            if (!$validate_result) {
                return error($validate->getError());
            }

            $data->role     = $param['role'];
            $data->nickname = $param['nickname'];
            $data->username = $param['username'];
            $data->password = $param['password'];
            $data->status   = $param['status'];
            $result = $data->save();

            return $result ? success() : error();
        }

        $role = AdminRole::all();

        return $this->admin_view('admin.admin_user.add',[
            'data' => $data,
            'role' => $role
        ]);

    }

    /**
     * 删除
     *
     * @param Request $request
     * @param AdminUser $model
     * Author: Stephen
     * Date: 2020/5/18 16:17
     */
    public function del(Request $request, AdminUser $model)
    {
        $id = $request->input('id');
        is_string($id) && $id = [$id];

        if (count($model->noDeletionId) > 0) {
            if (is_array($id)) {
                if (array_intersect($model->noDeletionId, $id)) {
                    return error('ID为' . implode(',', $model->noDeletionId) . '的数据无法删除');
                }
            } else if (in_array($id, $model->noDeletionId)) {
                return error('ID为' . $id . '的数据无法删除');
            }
        }

        $count = $model->destroy($id);

        return $count > 0 ? success('操作成功', URL_RELOAD) : error();
    }


    /**
     * 启用
     *
     * @param Request $request
     * @param AdminUser $model
     * Author: Stephen
     * Date: 2020/5/18 16:17
     */
    public function enable(Request $request, AdminUser $model)
    {
        $id = $request->input('id');
        is_string($id) && $id = [$id];

        $result = $model->whereIn('id', $id)->update(['status' => 1]);
        return $result ? success('操作成功', URL_RELOAD) : error();
    }

    /**
     * 禁用
     *
     * @param Request $request
     * @param AdminUser $model
     * Author: Stephen
     * Date: 2020/5/18 16:17
     */
    public function disable(Request $request, AdminUser $model)
    {
        $id = $request->input('id');
        is_string($id) && $id = [$id];

        $result = $model->whereIn('id', $id)->update(['status' => 0]);
        return $result ? success('操作成功', URL_RELOAD) : error();
    }

    /**
     * 个人资料
     *
     * @param Request $request
     * @param AdminUserValidate $validate
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:18
     */
    public function profile(Request $request, AdminUserValidate $validate)
    {
        if ($request->isMethod('post')) {
            $param = $request->input();

            if ($param['update_type'] === 'password') {

                $param['new_password_confirmation'] = $param['renew_password'];
                $validate_result = $validate->scene('password')->check($param);
                if (!$validate_result) {
                    return error($validate->getError());
                }

                if (!password_verify($param['password'], base64_decode($this->user->password))) {
                    return error('当前密码不正确');
                }

                $this->user->password = $param['new_password'];

            } else if ($param['update_type'] === 'avatar') {

                if (!$request->file('avatar')) {
                    return error('请上传新头像');
                }

                $attachment = new Attachment();
                $file       = $attachment->upload('avatar');
                if ($file) {
                    $this->user->avatar = $file->url;
                } else {
                    return error($attachment->getError());
                }

            }else if($param['update_type'] === 'profile'){

                $this->user->nickname = $param['nickname'];

            }

            if (false !== $this->user->save()) {

                return success('修改成功', URL_RELOAD);

            }

            return error();
        }

        return $this->admin_view('admin.admin_user.profile');
    }


}
