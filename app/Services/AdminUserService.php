<?php
/**
 * 用户管理 服务
 *
 * User: Stephen <474949931@qq.com>
 * Date: 2020/6/8
 * Time: 10:03
 */
namespace App\Services;

use App\Http\Model\Common\Attachment;
use App\Repositories\Admin\Contracts\AdminRoleInterface;
use App\Repositories\Admin\Contracts\AdminUserInterface;
use App\Validate\Admin\AdminUserValidate;
use Illuminate\Http\Request;

class AdminUserService extends AdminBaseService
{
    /**
     * @var Request 框架request对象
     */
    protected $request;

    /**
     * @var AdminUserValidate 用户验证
     */
    protected $validate;

    /**
     * @var AdminUserInterface 用户管理 仓库
     */
    protected $adminUser;

    /**
     * @var AdminRoleInterface 用户角色 仓库
     */
    protected $adminRole;

    /**
     * AdminUserService 构造函数.
     *
     * @param Request $request
     * @param AdminUserValidate $validate
     * @param AdminUserInterface $adminUser
     * @param AdminRoleInterface $adminRole
     */
    public function __construct(
        Request $request ,
        AdminUserValidate $validate ,
        AdminUserInterface $adminUser,
        AdminRoleInterface $adminRole
    )
    {
        $this->request   = $request;
        $this->validate  = $validate;
        $this->adminUser = $adminUser;
        $this->adminRole = $adminRole;
    }

    /**
     * 用户修改名称
     *
     * Author: Stephen
     * Date: 2020/7/27 17:16:57
     */
    public function updateNickName()
    {
        $param = $this->request->input();

        $loginUser = session(LOGIN_USER);
        if (false !== $this->adminUser->updateNickName($param,$loginUser)) {
            return success('修改成功', URL_RELOAD);
        }

        return error();
    }

    /**
     * 用户修改密码
     *
     * Author: Stephen
     * Date: 2020/7/27 17:17:17
     */
    public function updatePassword()
    {
        $param     = $this->request->input();
        $loginUser = session(LOGIN_USER);
        $param['new_password_confirmation'] = $param['renew_password'];
        $validate_result = $this->validate->scene('password')->check($param);

        if (!$validate_result) {
            return error($this->validate->getError());
        }

        if (!password_verify($param['password'], base64_decode($loginUser->password))) {
            return error('当前密码不正确');
        }

        if (false !== $this->adminUser->updatePassword($param,$loginUser)) {
            return success('修改成功', URL_RELOAD);
        }

        return error();
    }

    /**
     * 用户修改头像
     *
     * Author: Stephen
     * Date: 2020/7/27 17:17:40
     */
    public function updateAvatar()
    {
        $loginUser = session(LOGIN_USER);

        if (!$this->request->file('avatar')) {
            return error('请上传新头像');
        }

        $attachment = new Attachment();
        $file       = $attachment->upload('avatar');

        if ($file) {
            return $this->adminUser->updateAvatar($loginUser,$file) ? success('修改成功', URL_RELOAD) : error();
        } else {
            return error($attachment->getError());
        }
    }

    /**
     * 用户管理首页数据查询
     *
     * @return array
     * Author: Stephen
     * Date: 2020/7/27 17:18:03
     */
    public function getPageData()
    {
        $param = $this->request->input();

        $data  = $this->adminUser->getPageData($param,$this->perPage());

        return array_merge(['data'  => $data],$this->request->query());
    }

    /**
     * 获取所有角色
     *
     * @return mixed
     * Author: Stephen
     * Date: 2020/7/27 17:18:34
     */
    public function allRole()
    {
        return $this->adminRole->all();
    }

    /**
     * 创建用户
     *
     * Author: Stephen
     * Date: 2020/7/27 17:18:50
     */
    public function create()
    {
        $param           = $this->request->input();
        $validate_result = $this->validate->scene('add')->check($param);

        if (!$validate_result) {
            return error($this->validate->getError());
        }

        $result = $this->adminUser->create($param);

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
     * Date: 2020/7/27 17:19:08
     */
    public function edit($id)
    {
        return $this->adminUser->findById($id);
    }

    /**
     * 更新用户
     *
     * Author: Stephen
     * Date: 2020/7/27 17:19:28
     */
    public function update()
    {
        $param           = $this->request->input();

        $validate_result = $this->validate->scene('edit')->check($param);

        if (!$validate_result) {
            return error($this->validate->getError());
        }

        $result = $this->adminUser->update($param);

        return $result ? success() : error();
    }

    /**
     * 启用
     *
     * Author: Stephen
     * Date: 2020/7/27 17:19:45
     */
    public function enable()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        $result = $this->adminUser->enable($id);

        return $result ? success('操作成功', URL_RELOAD) : error();
    }

    /**
     * 禁用
     *
     * Author: Stephen
     * Date: 2020/7/27 17:19:57
     */
    public function disable()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        $result = $this->adminUser->disable($id);

        return $result ? success('操作成功', URL_RELOAD) : error();
    }

    /**
     * 删除用户
     *
     * Author: Stephen
     * Date: 2020/7/27 17:20:08
     */
    public function del()
    {
        $id = $this->request->input('id');
        is_string($id) && $id = [$id];

        $count = $this->adminUser->destroy($id);

        return $count > 0 ? success('操作成功', URL_RELOAD) : error();
    }

}