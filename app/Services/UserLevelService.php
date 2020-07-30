<?php
/**
 * 用户等级 Service
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/7/23
 * Time: 15:05
 */

namespace App\Services;

use App\Http\Model\Common\Attachment;
use App\Repositories\Admin\Contracts\UserLevelInterface;
use App\Traits\Admin\PhpOffice;
use App\Validate\Common\UserLevelValidate;
use Illuminate\Http\Request;

class UserLevelService extends AdminBaseService
{
    use PhpOffice;

    /**
     * @var Request 框架request对象
     */
    protected $request;

    /**
     * @var UserLevelInterface 用户等级 仓库
     */
    protected $userLevel;

    /**
     * @var UserLevelValidate 用户等级 验证器
     */
    protected $validate;

    /**
     * UserLevelService 构造函数.
     *
     * @param Request $request
     * @param UserLevelInterface $userLevel
     * @param UserLevelValidate $validate
     */
    public function __construct(
        Request $request ,
        UserLevelInterface $userLevel,
        UserLevelValidate $validate
    )
    {
        $this->request   = $request;
        $this->userLevel = $userLevel;
        $this->validate  = $validate;
    }

    /**
     * 用户等级首页查询数据
     *
     * @return array
     * Author: Stephen
     * Date: 2020/7/28 11:23:48
     */
    public function getPageData()
    {
        $param = $this->request->input();

        $data  = $this->userLevel->getPageData($param,$this->perPage());

        return array_merge(['data'  => $data],$this->request->query());
    }

    /**
     * 导出
     *
     * @return string|void
     * Author: Stephen
     * Date: 2020/7/28 11:24:17
     */
    public function export()
    {
        $param = $this->request->input();

        if (isset($param['export_data']) && $param['export_data'] == 1) {
            $header = ['ID', '名称', '简介', '是否启用', '创建时间',];
            $body   = [];
            $data   = $this->userLevel->get($param);
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

        return error();
    }

    /**
     * 获取用户等级
     *
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/28 11:24:29
     */
    public function getUserLevel()
    {
        $userLevelList = $this->userLevel->get();

        return $userLevelList;
    }

    /**
     * 创建用户等级
     *
     * Author: Stephen
     * Date: 2020/7/28 11:24:47
     */
    public function create()
    {
        $param           = $this->request->input();

        $validate_result = $this->validate->scene('add')->check($param);
        if (!$validate_result) {
            return error($this->validate->getError());
        }
        //处理图片上传
        $attachment_img = new Attachment;
        $file_img       = $attachment_img->upload('img');
        if ($file_img) {
            $param['img'] = $file_img->url;
        } else {
            return error($attachment_img->getError());
        }

        $result = $this->userLevel->create($param);

        $url = URL_BACK;
        if (isset($param['_create']) && $param['_create'] == 1) {
            $url = URL_RELOAD;
        }

        return $result ? success('添加成功', $url) : error();
    }

    /**
     * 编辑用户等级
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/28 11:25:10
     */
    public function edit($id)
    {
        return $this->userLevel->findById($id);
    }

    /**
     * 更新用户等级
     *
     * Author: Stephen
     * Date: 2020/7/28 11:25:26
     */
    public function update()
    {
        $param           = $this->request->input();

        $validate_result = $this->validate->scene('edit')->check($param);
        if (!$validate_result) {
            return error($this->validate->getError());
        }

        $result = $this->userLevel->update($param);

        return $result ? success() : error();
    }

    /**
     * 启用
     *
     * Author: Stephen
     * Date: 2020/7/28 11:25:43
     */
    public function enable()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        $result = $this->userLevel->enable($id);

        return $result ? success('操作成功', URL_RELOAD) : error();
    }

    /**
     * 禁用
     *
     * Author: Stephen
     * Date: 2020/7/28 11:25:57
     */
    public function disable()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        $result = $this->userLevel->disable($id);

        return $result ? success('操作成功', URL_RELOAD) : error();
    }

    /**
     * 删除用户等级
     *
     * Author: Stephen
     * Date: 2020/7/28 11:26:11
     */
    public function del()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        $count = $this->userLevel->destroy($id);

        return $count > 0 ? success('操作成功', URL_RELOAD) : error();
    }

}