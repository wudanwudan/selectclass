<?php
class StudentAction extends Action {
    public function index(){
        $this->display();
    }

    //选择课程
    public function chooseCourse(){
        $stu=M('student');
        $db_prefix=C('DB_PREFIX');
        $stuno =session('StuNo');
        $stuinfo=$stu->alias('st')->join('__CLASS__ as cl on cl.Classno=st.Classno')->find($stuno);
        $cou=M('course');
        $where['DepartNo'] =$stuinfo['DepartNo'];
        $coulist =$cou->field('c.*,sc.StuNo')->alias('c')->join("__STUCOU__ as sc on sc.CouNo = c.CouNo and sc.StuNo = '".$stuno."'")->where($while)->select();

        $this->assign('list',$coulist);
        $this->display();
    }

    //选择课程
    public function choseCourseDo(){
        $couno=$this->_get('CouNo');
        $stuno=session('StuNo');

        //判断所选课条件是否满足
        $StuNo['StuNo']=$stuno;
        $Stu=M("stucou")->where($StuNo)->select();
        $CouNo['CouNo']=$couno;
        $ChooseNum=M("course")->where($CouNo)->find();
        $stuCourse;

        //找出对应编号学生已选课程
        for($i=0;$i<count($Stu);$i++){
            $Cou['CouNo']=$Stu[$i]['CouNo'];
            $schooltime=M('course')->where($Cou)->find();
            $stuCourse[$i]['SchoolTime']=$schooltime['SchoolTime'];
            $stuCourse[$i]['t1']=$schooltime['t1'];
            $stuCourse[$i]['t2']=$schooltime['t2'];
            $stuCourse[$i]['t3']=$schooltime['t3'];
            $stuCourse[$i]['t4']=$schooltime['t4'];
            $stuCourse[$i]['t7']=$schooltime['t7'];
            $stuCourse[$i]['t8']=$schooltime['t8'];
            $stuCourse[$i]['t9']=$schooltime['t9'];
            $stuCourse[$i]['t10']=$schooltime['t10'];
            $stuCourse[$i]['t11']=$schooltime['t11'];
            $stuCourse[$i]['t12']=$schooltime['t12'];
            $stuCourse[$i]['t13']=$schooltime['t13'];
        }

        //判断是否时间冲突
        for($i=0;$i<count($stuCourse);$i++){
            if($ChooseNum['SchoolTime'] == $stuCourse[$i]['SchoolTime']){
                $this->error('选课时间冲突，选课失败！');
            }
            if($ChooseNum['Weekday'] == $stuCourse[$i]['Weekday']){
                if($ChooseNum['t1'] == 1 && $stuCourse[$i]['t1']==1){
                    $this->error('选课时间冲突，选课失败！');
                }
                if($ChooseNum['t2'] == 1 && $stuCourse[$i]['t2']==1){
                    $this->error('选课时间冲突，选课失败！');
                }
                if($ChooseNum['t3'] == 1 && $stuCourse[$i]['t3']==1){
                    $this->error('选课时间冲突，选课失败！');
                }
                if($ChooseNum['t4'] == 1 && $stuCourse[$i]['t4']==1){
                    $this->error('选课时间冲突，选课失败！');
                }
                if($ChooseNum['t7'] == 1 && $stuCourse[$i]['t7']==1){
                    $this->error('选课时间冲突，选课失败！');
                }
                if($ChooseNum['t8'] == 1 && $stuCourse[$i]['t8']==1){
                    $this->error('选课时间冲突，选课失败！');
                }
                if($ChooseNum['t9'] == 1 && $stuCourse[$i]['t9']==1){
                    $this->error('选课时间冲突，选课失败！');
                }
                if($ChooseNum['t10'] == 1 && $stuCourse[$i]['t10']==1){
                    $this->error('选课时间冲突，选课失败！');
                }
                if($ChooseNum['t11'] == 1 && $stuCourse[$i]['t11']==1){
                    $this->error('选课时间冲突，选课失败！');
                }
                if($ChooseNum['t12'] == 1 && $stuCourse[$i]['t12']==1){
                    $this->error('选课时间冲突，选课失败！');
                }
                if($ChooseNum['t13'] == 1 && $stuCourse[$i]['t13']==1){
                    $this->error('选课时间冲突，选课失败！');
                }
            }
        }

        //若选课成功，选课人数+1
        if($ChooseNum['ChooseNum'] >= $ChooseNum['LimitNum']){
            $this->error('人数已满，选课失败！');
        }
        else{
            $ChooseNum['ChooseNum']++;
            M("course")->save($ChooseNum);
        }

        //选课列表增加
        $data['StuNo']=$stuno;
        $data['CouNo']=$couno;
        M('stucou')->add($data);

        $this->success('选课成功！');
    }

    //显示已选课程
    public function courseList(){
        $StuNo['StuNo']=$_SESSION['StuNo'];
        $stu = M('stucou')->where($StuNo)->select();
        $stuCourse;
        for($i=0;$i<count($stu);$i++){
            $Cou['CouNo']=$stu[$i]['CouNo'];
            $coulist = M('course')->where($Cou)->find();
            $stuCourse[$i]['CouNo']=$coulist['CouNo'];
            $stuCourse[$i]['CouName']=$coulist['CouName'];
            $stuCourse[$i]['TeaName']=$coulist['TeaName'];
            $stuCourse[$i]['SchoolTime']=$coulist['SchoolTime'];
            $stuCourse[$i]['Location']=$coulist['Location'];
            $stuCourse[$i]['Credit']=$coulist['Credit'];
            $stuCourse[$i]['ClassHour']=$coulist['ClassHour'];
            $stuCourse[$i]['ExpHour']=$coulist['ExpHour'];
            $stuCourse[$i]['ChooseNum']=$coulist['ChooseNum'];
            $stuCourse[$i]['LimitNum']=$coulist['LimitNum'];
        }
        $this->assign('list',$stuCourse);
        $this->display();
    }

    //删除已选课程
    public function delete(){
        $CouNo=$this->_get('CouNo');
        $cou['StuNo']=$_SESSION['StuNo'];
        $cou['CouNo']=$CouNo;
        $mod=D('Stucou')->where($cou)->delete();

        //选课人数-1
        $Couno['CouNo']=$CouNo;
        $ChooseNum=M("course")->where($Couno)->find();
        $ChooseNum['ChooseNum']--;
        M("course")->save($ChooseNum);

        $this->success('已选课程删除成功！',U('/Student/courseList'));
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

        $this->success('正在跳转！',U('/Student/stuedit'));
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
        $StuNo['StuNo']=$_SESSION["StuNo"];
        $editstudent->where($StuNo)->save($data); // 根据条件保存修改的数据

        $Student['StuNo'] = $_POST["StuNo"];
        M('stucou')->where($StuNo)->save($Student);

        if(!$editstudent){
            $this->error('信息修改失败！');
        }
        else{
            $this->success('信息修改成功！',U('/Student/index'));
        }
	}
}
?>






