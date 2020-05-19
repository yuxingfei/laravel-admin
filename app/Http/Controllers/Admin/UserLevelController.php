<?php
/**
 * 用户等级控制器
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Http\Controllers\Admin;

use App\Model\Common\Attachment;
use Illuminate\Http\Request;
use App\Model\Common\UserLevel;
use App\Validate\Common\UserLevelValidate;

class UserLevelController extends AdminBaseController
{
    /**
     * 首页
     *
     * @param Request $request
     * @param UserLevel $model
     * @return \Illuminate\Contracts\Foundation\Application|mixed|string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:35
     */
    public function index(Request $request, UserLevel $model)
    {
        $param = $request->input();

        $model = $model->addWhere($param);
        if (isset($param['export_data']) && $param['export_data'] == 1) {
            $header = ['ID', '名称', '简介', '是否启用', '创建时间',];
            $body   = [];
            $data   = $model->get();
            foreach ($data as $item) {
                $record                = [];
                $record['id']          = $item->id;
                $record['name']        = $item->name;
                $record['description'] = $item->description;
                $record['status']      = $item->status == 1 ? '是' : '否';
                $record['create_time'] = $item->create_time->format('Y-m-d H:i:s');

                $body[] = $record;
            }
            return $this->exportData($header, $body, 'user_level-' . date('Y-m-d-H-i-s'));
        }
        $data = $model->paginate($this->admin['per_page']);

        //关键词，排序等赋值
        return $this->admin_view('admin.user_level.index',array_merge(['data'  => $data],$request->query()));
    }

    /**
     * 添加
     *
     * @param Request $request
     * @param UserLevel $model
     * @param UserLevelValidate $validate
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:35
     */
    public function add(Request $request, UserLevel $model, UserLevelValidate $validate)
    {
        if ($request->isMethod('post')) {
            $param           = $request->input();
            $validate_result = $validate->scene('add')->check($param);
            if (!$validate_result) {
                return error($validate->getError());
            }
            //处理图片上传
            $attachment_img = new Attachment;
            $file_img       = $attachment_img->upload('img');
            if ($file_img) {
                $param['img'] = $file_img->url;
            } else {
                return error($attachment_img->getError());
            }


            $result = $model::create($param);

            $url = URL_BACK;
            if (isset($param['_create']) && $param['_create'] == 1) {
                $url = URL_RELOAD;
            }

            return $result ? success('添加成功', $url) : error();
        }

        return $this->admin_view('admin.user_level.add');
    }

    /**
     * 修改
     *
     * @param $id
     * @param Request $request
     * @param UserLevel $model
     * @param UserLevelValidate $validate
     * @return \Illuminate\Contracts\Foundation\Application|mixed|void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * Author: Stephen
     * Date: 2020/5/18 16:35
     */
    public function edit($id, Request $request, UserLevel $model, UserLevelValidate $validate)
    {
        $data = $model::find($id);

        if ($request->isMethod('post')) {
            $param           = $request->input();
            $validate_result = $validate->scene('edit')->check($param);
            if (!$validate_result) {
                return error($validate->getError());
            }
            //处理图片上传
            if (!empty($request->file('img'))) {
                $attachment_img = new Attachment;
                $file_img       = $attachment_img->upload('img');
                if ($file_img) {
                    $data->img = $file_img->url;
                }
            }

            $data->name        = $param['name'];
            $data->description = $param['description'];
            $data->status      = $param['status'];

            $result = $data->save();
            return $result ? success() : error();
        }

        return $this->admin_view('admin.user_level.add',['data' => $data]);

    }

    /**
     * 删除
     *
     * @param Request $request
     * @param UserLevel $model
     * Author: Stephen
     * Date: 2020/5/18 16:36
     */
    public function del(Request $request, UserLevel $model)
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
     * @param UserLevel $model
     * Author: Stephen
     * Date: 2020/5/18 16:36
     */
    public function enable(Request $request, UserLevel $model)
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
     * @param UserLevel $model
     * Author: Stephen
     * Date: 2020/5/18 16:36
     */
    public function disable(Request $request, UserLevel $model)
    {
        $id = $request->input('id');
        is_string($id) && $id = [$id];

        $result = $model->whereIn('id', $id)->update(['status' => 0]);
        return $result ? success('操作成功', URL_RELOAD) : error();
    }
}
