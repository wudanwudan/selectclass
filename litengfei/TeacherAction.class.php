<?php
class TeacherAction extends Action {
    public function index(){
	    $this->display();
	}


    public function add(){
        $this->display();
    }

    //添加课程
    public function add_do(){
        $cou=D('Course');
        $re=$cou->create($_POST,1);
        if(!$re){
            $this->error($cou->getError());
        }
        $r=$cou->add($re);
        if(!$r){
            $this->error('课程创建失败！');
        }
        else{
            $this->success('课程创建成功！',U('/Teacher/coulist'));
        }
    }

    //显示课程
    public function coulist(){
        $where['TeaNo']=$_SESSION['TeaNo'];
        $teacoulist = M('course')->where($where)->select();
        $this->assign('list',$teacoulist);
        $this->display();
    }

    //查看选课学生详细信息
    public function courseListDetail(){
        //找出选这门课的学生的学号
        $CouNo=$_POST['CouNo'];
        $Course['CouNo']=$CouNo;
        $stulist=M('stucou')->where($Course)->select();
        $stuMessage;
        //找出这个学号对应的学生名字
        for($i=0;$i<count($stulist);$i++){
            $stuInfo['StuNo']=$stulist[$i]['StuNo'];
            $studetail=M('student')->where($stuInfo)->find();
            $stuMessage[$i]['StuNo']=$studetail['StuNo'];
            $stuMessage[$i]['StuName']=$studetail['StuName'];
            $stuMessage[$i]['ClassNo']=$studetail['ClassNo'];
            $stuMessage[$i]['ClassName']=$studetail['ClassName'];
            $stuMessage[$i]['Sex']=$studetail['Sex'];
        }
        $this->assign('list',$stuMessage);
        $this->display();
    }

    //编辑课程
    //传递此门课程参数
    public function edit_do(){
        $CouNo=$_POST['CouNo'];

        $Course['CouNo']=$CouNo;
        $courseInfo=M('course')->where($Course)->find();
        session('editCouNo',$courseInfo['CouNo']);
        session('editCouName',$courseInfo['CouName']);
        session('editTeaNo',$courseInfo['TeaNo']);
        session('editTeaName',$courseInfo['TeaName']);
        session('editLimitNum',$courseInfo['LimitNum']);
        session('editCredit',$courseInfo['Credit']);
        session('editSchoolTime',$courseInfo['SchoolTime']);
        session('editLocation',$courseInfo['Location']);
        session('editClassHour',$courseInfo['ClassHour']);
        session('editExpHour',$courseInfo['ExpHour']);

        $this->success('正在跳转！',U('/Teacher/edit'));
    }
    //显示默认参数
    public function edit(){
        $this->display();
    }
    //修改提交新参数并跳转
    public function edit_edit(){
        // 要修改的数据对象属性赋值
        $data['CouNo'] = $_POST["CouNo"];
        $data['CouName'] = $_POST["CouName"];
        $data['TeaNo'] = $_POST["TeaNo"];
        $data['TeaName'] = $_POST["TeaName"];
        $data['LimitNum'] = $_POST["LimitNum"];
        $data['Credit'] = $_POST["Credit"];
        $data['SchoolTime'] = $_POST["SchoolTime"];
        $data['Location'] = $_POST["Location"];
        $data['ClassHour'] = $_POST["ClassHour"];
        $data['ExpHour'] = $_POST["ExpHour"];
        $CouNo['CouNo']=$_SESSION["editCouNo"];
        M("course")->where($CouNo)->save($data); // 根据条件保存修改的数据

        $this->success('课程信息修改成功！',U('/Teacher/coulist'));
    }

    //删除课程
    public function delete(){
        $CouNo=$this->_get('CouNo');
        $mod=M('course')->where("CouNo = '$CouNo'")->delete();
        M('stucou')->where("CouNo = '$CouNo'")->delete();

        if($mod){
            $this->success('课程删除成功',U('/Teacher/coulist'));

        }else{
            $this->success('课程删除失败！');
        }
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

        $this->success('正在跳转！',U('/Teacher/teaedit'));
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
        $TeaNo['TeaNo']=$_SESSION["TeaNo"];
        $editteacher->where($TeaNo)->save($data); // 根据条件保存修改的数据

        $Teacher['TeaNo'] = $_POST["TeaNo"];
        $Teacher['TeaName'] = $_POST["TeaName"];
        M('course')->where($TeaNo)->save($Teacher);


        if(!$editteacher){
            $this->error('信息修改失败！');
        }
        else{
            $this->success('信息修改成功！',U('/Teacher/index'));
        }
	}
}
?>

