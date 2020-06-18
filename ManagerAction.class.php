<?php
class ManagerAction extends Action {
    public function index(){
	    $this->display();
	}

    //添加学生信息
    public function stuadd(){
        $this->display();
    }
    public function stuadd_do(){
        $stu=D('Student');
        $res=$stu->create($_POST,1);
        if(!$res){
            $this->error($stu->getError());
        }
        $stu->StuNo=$_SESSION['StuNo'];
        $re=$stu->add($res);

        if(!$re){
            $this->error('学生信息添加失败！');
        }
        else{
            $this->success('学生信息添加成功！',U('/Manager/stulist'));
        }
    }

    //显示学生信息
    public function stulist(){
        $stu = M('Student');
        $where['StuNo']=$_SESSION['StuNo'];
        $stulist = $stu->order('StuNo asc')->select();
        $this->assign('list',$stulist);
        $this->display();
    }

    //编辑学生
    //传递此学生参数
    public function stuedit_do(){
        $StuNo=$_POST['StuNo'];

        $Student['StuNo']=$StuNo;
        $studentInfo=M('student')->where($Student)->find();
        session('editStuNo',$studentInfo['StuNo']);
        session('editStuName',$studentInfo['StuName']);
        session('editClassNo',$studentInfo['ClassNo']);
        session('editClassName',$studentInfo['ClassName']);
        session('editPwd',$studentInfo['Pwd']);
        session('editSex',$studentInfo['Sex']);

        $this->success('正在跳转！',U('/Manager/stuedit'));
    }
    //显示默认学生参数
    public function stuedit(){
        $this->display();
    }
    //修改提交新参数并跳转
    public function stuedit_edit(){
        $editstudent = M("student"); // 实例化User对象
        // 要修改的数据对象属性赋值
        $data['StuNo'] = $_POST["StuNo"];
        $data['StuName'] = $_POST["StuName"];
        $data['ClassNo'] = $_POST["ClassNo"];
        $data['ClassName'] = $_POST["ClassName"];
        $data['Pwd'] = $_POST["Pwd"];
        $data['Sex'] = $_POST["Sex"];
        $StuNo['StuNo']=$_POST["StuNo"];
        $editstudent->where($CouNo)->save($data); // 根据条件保存修改的数据

        if(!$editstudent){
            $this->error('学生信息修改失败！');
        }
        else{
            $this->success('学生信息修改成功！',U('/Manager/stulist'));
        }
	}

    //删除学生信息
    public function deleteStudent(){
        $StuNo=$this->_get('StuNo');
        $mod=D('student')->where("StuNo = '$StuNo' ")->delete();
        if (!$mod){
            $this->error('删除学生信息失败！');
         }
        else{
            $this->success('删除学生信息成功！',U('/Manager/stulist'));
        }
    }



    //添加老师信息
    public function teaadd(){
        $this->display();
    }
    public function teaadd_do(){
        $stu=D('Teacher');
        $res=$tea->create($_POST,1);
        if(!$res){
            $this->error($stu->getError());
        }
        $tea->TeaNo=$_SESSION['TeaNo'];
        $re=$tea->add($res);

        if(!$re){
            $this->error('学生信息添加失败！');
        }
        else{
            $this->success('学生信息添加成功！',U('/Manager/tealist'));
        }
    }

    //显示老师信息
    public function tealist(){
        $tea = M('teacher');
        $where['TeaNo']=$_SESSION['TeaNo'];
        $tealist = $tea->order('TeaNo asc')->select();
        $this->assign('list',$tealist);
        $this->display();
    }

    //编辑老师
    //传递此老师参数
    public function teaedit_do(){
        $TeaNo=$_POST['TeaNo'];

        $Teacher['TeaNo']=$TeaNo;
        $teacherInfo=M('teacher')->where($Teacher)->find();
        session('editTeaNo',$teacherInfo['TeaNo']);
        session('editTeaName',$teacherInfo['TeaName']);
        session('editClassNo',$teacherInfo['ClassNo']);
        session('editClassName',$teacherInfo['ClassName']);
        session('editPwd',$teacherInfo['Pwd']);
        session('editSex',$teacherInfo['Sex']);
        session('editIntroduction',$teacherInfo['Introduction']);

        $this->success('正在跳转！',U('/Manager/teaedit'));
    }
    //显示默认老师参数
    public function teaedit(){
        $this->display();
    }
    //修改提交新参数并跳转
    public function teaedit_edit(){
        $editteacher = M("teacher"); // 实例化User对象
        // 要修改的数据对象属性赋值
        $data['TeaNo'] = $_POST["TeaNo"];
        $data['TeaName'] = $_POST["TeaName"];
        $data['ClassNo'] = $_POST["ClassNo"];
        $data['ClassName'] = $_POST["ClassName"];
        $data['Pwd'] = $_POST["Pwd"];
        $data['Sex'] = $_POST["Sex"];
        $data['Introduction'] = $_POST["Introduction"];
        $TeaNo['TeaNo']=$_POST["TeaNo"];
        $editteacher->where($TeaNo)->save($data); // 根据条件保存修改的数据

        if(!$editteacher){
            $this->error('老师信息修改失败！');
        }
        else{
            $this->success('老师信息修改成功！',U('/Manager/tealist'));
        }
	}

    //删除老师信息
    public function deleteTeachert(){
        $TeaNo=$this->_get('TeaNo');
        $mod=D('teacher')->where("TeaNo = '$TeaNo' ")->delete();
        if (!$mod){
            $this->error('删除老师信息失败！');
         }
        else{
            $this->success('删除老师信息成功！',U('/Manager/tealist'));
        }
    }


    //编辑管理员
    //传递此管理员参数
    public function manedit_do(){
        $ManNo=$_POST['ManNo'];

        $Manager['ManNo']=$ManNo;
        $managerInfo=M('manager')->where($Manager)->find();
        session('editManNo',$managerInfo['ManNo']);
        session('editManName',$managerInfo['ManName']);
        session('editPwd',$managerInfo['Pwd']);

        $this->success('正在跳转！',U('/Manager/manedit'));
    }
    //显示默认老师参数
    public function manedit(){
        $this->display();
    }
    //修改提交新参数并跳转
    public function manedit_edit(){
        $editmanager = M("manager"); // 实例化User对象
        // 要修改的数据对象属性赋值
        $data['ManNo'] = $_POST["ManNo"];
        $data['ManName'] = $_POST["ManName"];
        $data['Pwd'] = $_POST["Pwd"];
        $ManNo['ManNo']=$_SESSION["ManNo"];
        $editmanager->where($ManNo)->save($data); // 根据条件保存修改的数据

        if(!$editmanager){
            $this->error('信息修改失败！');
        }
        else{
            $this->success('信息修改成功！',U('/Manager/index'));
        }
    }
}
?>