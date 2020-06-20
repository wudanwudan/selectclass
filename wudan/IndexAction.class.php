<?php
class IndexAction extends Action {
    //显示登录页面
    public function index(){
	    $this->display();
    }

	//登录验证
	public function checkLogin(){
	    //获取输入的值
		$username = $this->_post("username");
		$pwd =$this->_post("password");
		$usertype =$this->_post('role');

		//判断是否输入用户名密码
		if(!$username){
		    $this->error('请输入用户名！');
		}
        if(!$pwd){
            $this->error('请输入密码');
        }

        //学生
        if($usertype =='student'){
            //查询条件获取
            $condition['StuNo']=$username;
            $condition['Pwd']=$pwd;

            //查询学生信息
            $userinfo =M('student')->where($condition)->find();

            //与数据库中的信息比对
            if(!$userinfo)
                $this->error('用户名不存在');
            if(!$userinfo['Pwd']==$pwd)
                $this->error('用户密码错误');
            else{
                $Class['ClassNo']=$userinfo['ClassNo'];
                $classInfo=M('class')->where($Class)->find();

                //保存此学生信息
                session('role',$userinfo['student']);
                session('StuNo',$userinfo['StuNo']);
                session('StuName',$userinfo['StuName']);
                session('ClassNo',$userinfo['ClassNo']);
                session('ClassName',$classInfo['ClassName']);
                session('Pwd',$userinfo['Pwd']);
                session('Sex',$userinfo['Sex']);
                $this->success('登录成功',U('/Student/index'));
            }
        }

        //老师
        if($usertype =='teacher'){
            //查询条件
            $condition['TeaNo']=$username;
            $condition['Pwd']=$pwd;

            //查询数据
            $userinfo = M('teacher')->where($condition)->find();
            if(!$userinfo)
                $this->error('用户名不存在');
            if(!$userinfo['Pwd']==$pwd)
                $this->error('用户密码错误');
            else{
                $Class['ClassNo']=$userinfo['ClassNo'];
                $classInfo=M('class')->where($Class)->find();

                session('role',$userinfo['teacher']);
                session('TeaNo',$userinfo['TeaNo']);
                session('TeaName',$userinfo['TeaName']);
                session('ClassNo',$userinfo['ClassNo']);
                session('ClassName',$classInfo['ClassName']);
                session('Pwd',$userinfo['Pwd']);
                session('Sex',$userinfo['Sex']);
                session('Introduction',$userinfo['Introduction']);
                $this->success('登录成功',U('/Teacher/index'));
            }
        }

        //管理员

        if($usertype == 'manager'){
            $manager = M('manager');

            //查询条件
            $condition['ManNo']=$username;
            $condition['Pwd']=$pwd;
            //查询数据
            $userinfo = $manager->where($condition)->find();
            if(!$userinfo)
                $this->error('用户名不存在');
            if(!$userinfo['Pwd']==$pwd)
                $this->error('用户密码错误');
            else{
                session('rol',$userinfo['manger']);
                session('ManNo',$userinfo['ManNo']);
                session('ManName',$userinfo['ManName']);
                session('Pwd',$userinfo['Pwd']);
                $this->success('登陆成功',U('/Manager/index'));
            }
        }

    }
}
?>






