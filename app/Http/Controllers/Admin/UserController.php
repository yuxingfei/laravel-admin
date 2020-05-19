<?php
/**
 * 用户控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use App\Model\Common\Attachment;
use App\Validate\Common\UserValidate;
use Illuminate\Http\Request;
use App\Model\Common\User;
use App\Model\Common\UserLevel;


class UserController extends AdminBaseController
{
    /**
     * 首页
     *
     * @param Request $request
     * @param User $model
     * @return \Illuminate\Contracts\Foundation\Application|mixed|string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:33
     */
    public function index(Request $request, User $model)
    {
        $param = $request->input();

        $model = $model->with('userLevel')->addWhere($param);
        if (isset($param['export_data']) && $param['export_data'] == 1) {
            $header = ['ID', '头像', '用户等级', '用户名', '手机号', '昵称', '是否启用', '创建时间',];
            $body   = [];
            $data   = $model->get();
            foreach ($data as $item) {
                $record                  = [];
                $record['id']            = $item->id;
                $record['avatar']        = $item->avatar;
                $record['user_level_id'] = $item->userLevel->name ?? '';
                $record['username']      = $item->username;
                $record['mobile']        = $item->mobile;
                $record['nickname']      = $item->nickname;
                $record['status']        = $item->status == 1 ? '是':'否';
                $record['create_time']   = $item->create_time->format('Y-m-d H:i:s');

                $body[] = $record;
            }
            return $this->exportData($header, $body, 'user-' . date('Y-m-d-H-i-s'));
        }
        $data = $model->paginate($this->admin['per_page']);

        //关键词，排序等赋值
        return $this->admin_view('admin.user.index',array_merge(['data'  => $data],$request->query()));
    }

    /**
     * 添加
     *
     * @param Request $request
     * @param User $model
     * @param UserValidate $validate
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:34
     */
    public function add(Request $request, User $model, UserValidate $validate)
    {
        if ($request->isMethod('post')) {
            $param           = $request->input();

            $validate_result = $validate->scene('add')->check($param);
            if (!$validate_result) {
                return error($validate->getError());
            }
            //处理头像上传
            $attachment_avatar = new Attachment;
            $file_avatar       = $attachment_avatar->upload('avatar');
            if ($file_avatar) {
                $param['avatar'] = $file_avatar->url;
            } else {
                return error($attachment_avatar->getError());
            }


            $result = $model::create($param);

            $url = URL_BACK;
            if (isset($param['_create']) && $param['_create'] == 1) {
                $url = URL_RELOAD;
            }

            return $result ? success('添加成功', $url) : error();
        }

        return $this->admin_view('admin.user.add',['user_level_list' => UserLevel::get()]);
    }

    /**
     * 修改
     *
     * @param $id
     * @param Request $request
     * @param User $model
     * @param UserValidate $validate
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:34
     */
    public function edit($id, Request $request, User $model, UserValidate $validate)
    {
        $data = $model::find($id);

        if ($request->isMethod('post')) {
            $param           = $request->input();
            $validate_result = $validate->scene('edit')->check($param);
            if (!$validate_result) {
                return error($validate->getError());
            }
            //处理头像上传
            if (!empty($request->file('avatar'))) {
                $attachment_avatar = new Attachment;
                $file_avatar       = $attachment_avatar->upload('avatar');
                if ($file_avatar) {
                    $data->avatar = $file_avatar->url;
                }
            }
            $data->user_level_id = $param['user_level_id'];
            $data->username      = $param['username'];
            $data->mobile        = $param['mobile'];
            $data->nickname      = $param['nickname'];
            $data->password      = $param['password'];
            $data->status        = $param['status'];

            $result = $data->save();

            return $result ? success() : error();
        }

        return $this->admin_view('admin.user.add',[
            'data'            => $data,
            'user_level_list' => UserLevel::get()
        ]);

    }

    /**
     * 删除
     *
     * @param Request $request
     * @param User $model
     * Author: Stephen
     * Date: 2020/5/18 16:34
     */
    public function del(Request $request, User $model)
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
     * @param User $model
     * Author: Stephen
     * Date: 2020/5/18 16:34
     */
    public function enable(Request $request, User $model)
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
     * @param User $model
     * Author: Stephen
     * Date: 2020/5/18 16:35
     */
    public function disable(Request $request, User $model)
    {
        $id = $request->input('id');
        is_string($id) && $id = [$id];

        $result = $model->whereIn('id', $id)->update(['status' => 0]);
        return $result ? success('操作成功', URL_RELOAD) : error();
    }
}
