<?php
/**
 * 用户管理 Service
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/8
 * Time: 10:03
 */
namespace App\Services;

use App\Http\Model\Common\Attachment;
use App\Repositories\Admin\Contracts\UserInterface;
use App\Repositories\Admin\Contracts\UserLevelInterface;
use App\Traits\Admin\PhpOffice;
use App\Validate\Common\UserValidate;
use Illuminate\Http\Request;

class UserService extends AdminBaseService
{
    use PhpOffice;

    /**
     * @var Request 框架request对象
     */
    protected $request;

    /**
     * @var UserInterface 用户 仓库
     */
    protected $user;

    /**
     * @var UserLevelInterface 用户等级仓库
     */
    protected $userLevel;

    /**
     * @var UserValidate 用户验证器
     */
    protected $validate;

    /**
     * UserService 构造函数.
     *
     * @param Request $request
     * @param UserInterface $user
     * @param UserLevelInterface $userLevel
     * @param UserValidate $validate
     */
    public function __construct(
        Request $request ,
        UserInterface $user,
        UserLevelInterface $userLevel,
        UserValidate $validate
    )
    {
        $this->request   = $request;
        $this->user      = $user;
        $this->userLevel = $userLevel;
        $this->validate  = $validate;
    }

    /**
     * 用户首页数据查询
     *
     * @return array
     * Author: Stephen
     * Date: 2020/7/28 11:28:03
     */
    public function getPageData()
    {
        $param = $this->request->input();

        $data  = $this->user->getPageData($param,$this->perPage());

        return array_merge(['data'  => $data],$this->request->query());
    }

    /**
     * 导出
     *
     * @return string|void
     * Author: Stephen
     * Date: 2020/7/28 11:28:24
     */
    public function export()
    {
        $param = $this->request->input();

        if (isset($param['export_data']) && $param['export_data'] == 1) {
            $header = ['ID', '头像', '用户等级', '用户名', '手机号', '昵称', '是否启用', '创建时间',];
            $body   = [];
            $data   = $this->user->get($param);
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

        return error();
    }

    /**
     * 获取用户等级
     *
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/28 11:28:33
     */
    public function getUserLevel()
    {
        $param           = $this->request->input();

        $userLevelList = $this->userLevel->get($param);

        return $userLevelList;
    }

    /**
     * 创建用户
     *
     * Author: Stephen
     * Date: 2020/7/28 11:28:46
     */
    public function create()
    {
        $param           = $this->request->input();

        $validate_result = $this->validate->scene('add')->check($param);
        if (!$validate_result) {
            return error($this->validate->getError());
        }

        //处理头像上传
        $attachment_avatar = new Attachment();
        $file_avatar       = $attachment_avatar->upload('avatar');
        if ($file_avatar) {
            $param['avatar'] = $file_avatar->url;
        } else {
            return error($attachment_avatar->getError());
        }

        $result = $this->user->create($param);

        $url = URL_BACK;
        if (isset($param['_create']) && $param['_create'] == 1) {
            $url = URL_RELOAD;
        }

        return $result ? success('添加成功', $url) : error();
    }

    /**
     * 编辑用户
     *
     * @param $id
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/28 11:29:01
     */
    public function edit($id)
    {
        return $this->user->findById($id);
    }

    /**
     * 更新用户
     *
     * Author: Stephen
     * Date: 2020/7/28 11:29:13
     */
    public function update()
    {
        $param           = $this->request->input();

        $validate_result = $this->validate->scene('edit')->check($param);

        if (!$validate_result) {
            return error($this->validate->getError());
        }

        $result = $this->user->update($param);

        return $result ? success() : error();
    }

    /**
     * 启用
     *
     * Author: Stephen
     * Date: 2020/7/28 11:29:25
     */
    public function enable()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        $result = $this->user->enable($id);

        return $result ? success('操作成功', URL_RELOAD) : error();
    }

    /**
     * 禁用
     *
     * Author: Stephen
     * Date: 2020/7/28 11:29:36
     */
    public function disable()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        $result = $this->user->disable($id);

        return $result ? success('操作成功', URL_RELOAD) : error();
    }

    /**
     * 删除用户
     *
     * Author: Stephen
     * Date: 2020/7/28 11:29:47
     */
    public function del()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        $count = $this->user->destroy($id);

        return $count > 0 ? success('操作成功', URL_RELOAD) : error();
    }

}