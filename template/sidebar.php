<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="active">
              <a href="index.php">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
            <li class="">
              <a href="time_management.php">
                <i class="fa fa-clock-o"></i> <span>My Attendance</span>
              </a>
            </li>
            <li class='header'>REQUEST APPROVAL MENU</li>
              <?php
              $overtime_count=$con->myQuery("SELECT 
                COUNT(id)
                FROM vw_employees_ot
                WHERE CASE 
                when status='Supervisor Approval' then supervisor_id 
                when status='Final Approver Approval' then final_approver_id
                end 
                =:employee_id
                ",array("employee_id"=>$_SESSION[WEBAPP]['user']['employee_id']))->fetchColumn();
            ?>
            <li ><a href='overtime_approval.php'><i class="fa fa-file-text"></i><span>Overtime </span> <?php echo empty($overtime_count)?'':"<small class='label pull-right bg-primary'>{$overtime_count}</small>";?></a>  </li>
            <li ><a href='leave_approval.php'><i class="fa fa-file-text"></i><span>Leave</span></a></li>
            <li ><a href='#'><i class="fa fa-file-text"></i><span>Official Business</span></a></li>
            <li ><a href='#'><i class="fa fa-file-text"></i><span>Change Shift</span></a></li>
            <li ><a href='#'><i class="fa fa-file-text"></i><span>Attendance<br/> Adjustment </span></a></li>
            <li class='header'>EMPLOYEE SELF SERVICE MENU</li>
            <li class='treeview'>
              <a href="#">
                <i class="fa fa-file-text"></i>
                <span>My Requests</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class='treeview-menu'>
                <li class="">
                  <a href="overtime_request.php"><i class="fa fa-circle-o"></i> <span>Overtime</span></a>
                </li>
                <li class="">
                  <a href="employee_leave_request.php"><i class="fa fa-circle-o"></i> <span>Leave</span></a>
                </li>
                <li class="">
                  <a href="#"><i class="fa fa-circle-o"></i> <span>Attendance Adjustments</span></a>
                </li>
                <li class="">
                  <a href="#"><i class="fa fa-circle-o"></i> <span>Change Shift</span></a>
                </li>
                <li class="">
                  <a href="#"><i class="fa fa-circle-o"></i> <span>Official Business</span></a>
                </li>
              </ul>
            </li>
            <li class='treeview'>
              <a href="#">
                <i class="fa fa-file"></i>
                <span>Document Management</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class='treeview-menu'>
                <li class="">
                  <a href="#"><i class="fa fa-circle-o"></i> <span>Company Files</span></a>
                </li>
                <li class="">
                  <a href="#"><i class="fa fa-circle-o"></i> <span>My Files</span></a>
                </li>
              </ul>
            </li>
            <li class='treeview'>
              <a href="#">
                <i class="fa fa-file-text"></i>
                <span>Reports</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class='treeview-menu'>
                <li class="">
                  <a href="attendance_report.php"><i class="fa fa-circle-o"></i> <span>Attendance Report</span></a>
                </li>
                <li class="">
                  <a href="dtr_report.php"><i class="fa fa-circle-o"></i> <span>DTR Report</span></a>
                </li>
                <li class="">
                  <a href="#"><i class="fa fa-circle-o"></i> <span>Leaves Report</span></a>
                </li>
                <li class="">
                  <a href="#"><i class="fa fa-circle-o"></i> <span>Leaves Entitlement Report</span></a>
                </li>
                <?php
                  if(AllowUser(array(1))):
                ?>
                <li class="">
                  <a href="#"><i class="fa fa-circle-o"></i> <span>Employee List</span></a>
                </li>
                <?php
                  endif;
                ?>
                <li class="">
                  <a href="#"><i class="fa fa-circle-o"></i> <span>Employee Details</span></a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-circle-o"></i> <span>Attendance Adjustments</span>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-circle-o"></i> <span>Shift Change
                    </span>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-circle-o"></i> <span>Official Business</span>
                  </a>
                </li>
              </ul>
            </li>
            <?php
              if(AllowUser(array(1))):
            ?>
            <li class='header'>ADMINISTRATOR MENU</li>
            <li class='treeview'>
              <a href=''><i class="fa fa-cubes"></i><span>Administrator</span><i class="fa fa-angle-left pull-right"></i></a>
              <ul class='treeview-menu'>
                <li class="">
                  <a href="employees.php">
                    <i class="fa fa-users"></i> <span>Employees</span>
                  </a>
                </li>
                <li class="">
                  <a href="users.php">
                    <i class="fa fa-users"></i> <span>Users</span>
                  </a>
                </li>
                <li class=''>
                  <a href="#">
                    <i class="fa fa-check-square-o"></i>
                    <span>Job Details</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class='treeview-menu'>
                    <li class="">
                      <a href="education_level.php"><i class="fa fa-circle-o"></i> <span>Education Levels</span></a>
                    </li>
                    <li class="">
                      <a href="skills.php"><i class="fa fa-circle-o"></i> <span>Skills</span></a>
                    </li>
                    <li class="">
                      <a href="trainings.php"><i class="fa fa-circle-o"></i> <span>Trainings</span></a>
                    </li>
                    <li class="">
                      <a href="certifications.php"><i class="fa fa-circle-o"></i> <span>Certifications</span></a>
                    </li>
                    <li class="">
                      <a href="job_title.php"><i class="fa fa-circle-o"></i> <span>Job Titles</span></a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="leave_type.php">
                    <i class="fa fa-building"></i> <span>Leaves</span>
                  </a>
                </li>
                <li>
                  <a href="departments.php">
                    <i class="fa fa-building"></i> <span>Deparments</span>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <i class="fa fa-clock-o"></i> <span>Monitor Attendance</span>
                  </a>
                </li>
                <li class=''>
                  <a href="#">
                    <i class="fa fa-check-square-o"></i>
                    <span>Document Management</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class='treeview-menu'>
                    <li class="">
                      <a href="#"><i class="fa fa-circle-o"></i> <span>Company Files</span></a>
                    </li>
                    <li class="">
                      <a href="#"><i class="fa fa-circle-o"></i> <span>Employee Files</span></a>
                    </li>
                  </ul>
                </li>
                <li class='treeview'>
                  <a href="#">
                    <i class="fa fa-sort-alpha-asc"></i>
                    <span>Metadata</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class='treeview-menu'>
                    <li class="">
                      <a href="tax_status.php"><i class="fa fa-circle-o"></i> <span>Tax Status</span></a>
                    </li>
                    <li class="">
                      <a href="#"><i class="fa fa-circle-o"></i> <span>Pay Grades</span></a>
                    </li>
                    <li class="">
                      <a href="employment_status.php"><i class="fa fa-circle-o"></i> <span>Employment Status</span></a>
                    </li>
                    <li class="">
                      <a href="approval_matrix.php"><i class="fa fa-circle-o"></i> <span>Approval Matrix</span></a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <?php
              endif;
            ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>