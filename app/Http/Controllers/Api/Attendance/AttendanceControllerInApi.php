<?php

namespace App\Http\Controllers\Api\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Attendance;
use App\Models\Leave;
use DateInterval;



use Str;

use Exception;

class AttendanceControllerInApi extends Controller
{

    public function addAttendance(Request $request)
    {
        try {
            $user = auth()->user();

            if($request->is_present=='1'){


                $saveAttendance = new Attendance();

                $saveAttendance->user_id = $user->id;
                $saveAttendance->is_present = '1';
                $saveAttendance->current_location = $request->current_location;
                $saveAttendance->attendance_date = date("Y-m-d");
                $saveAttendance->attendance_time = date("H:i:s");

                $saveAttendance->save();

                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'Added Successfully.';

            }else{

                $result['status'] = 500;
                $result['success'] = false;
                $result['message'] = 'Something went wrong.';

            }

            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }
    
    public function addLeave(Request $request)
    {
        try {
            $user = auth()->user();

            if($request->leave_date!=''){


                $saveLeave = new Leave();

                $saveLeave->user_id = $user->id;
                $saveLeave->leave_type = $request->leave_type;
                $saveLeave->day_type = $request->day_type;
                $saveLeave->leave_date = $request->leave_date;
                
                $saveLeave->save();

                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'Added Successfully.';

            }else{

                $result['status'] = 500;
                $result['success'] = false;
                $result['message'] = 'Something went wrong.';

            }

            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }

    public function attendanceSheet(Request $request)
    {
        try {
            $user = auth()->user();

            if($request->type=='Monthly'){


                $user_id = $user->id;
                $month = $request->month;
                $year = $request->year;

                $days_month=cal_days_in_month(CAL_GREGORIAN,$month,$year);
                $present=0;
                $absent=0;
                $list=[];
                for($i=1;$i<=$days_month;$i++){

                    $date_month=date('Y-m-d', strtotime($year.'-'.$month.'-'.$i));

                    @$is_checkin = Attendance::where('user_id', $user_id)->where('attendance_date', $date_month)->first();
                    if(@$is_checkin->id!=""){
                        $mark="1";
                        $present++;
                     }elseif(date("Y-m-d")<$date_month){
                        $mark="";
                     }else{
                        $mark="0";
                        $absent++;
                     }

                     $list[$date_month]=array(
                         "is_present"=>$mark,
                         "start_time"=>@$is_checkin->start_time,
                         "start_location"=>@$is_checkin->start_location,
                         "end_time"=>@$is_checkin->end_time,
                         "end_time"=>@$is_checkin->end_time,

                     );

                }


                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'Attendance Sheet.';
                $result['present'] = $present;
                $result['absent'] = $absent;
                $result['working_days'] = $days_month;
                $result['data'] = $list;

            }elseif($request->type=='Date Range'){

                $user_id = $user->id;
                $start_date = new \DateTime($request->start_date);
                $end_date = new \DateTime($request->end_date);

                $days_month = $start_date->diff($end_date)->days;

                $present=0;
                $absent=0;
                $list=[];
                for($i=1;$i<=$days_month;$i++){

                    $date_month = $start_date->add(new DateInterval("P{$i}D"))->format('Y-m-d');

                    @$is_checkin = Attendance::where('user_id', $user_id)->where('attendance_date', $date_month)->first();
                    if(@$is_checkin->id!=""){
                        $mark="1";
                        $present++;
                     }elseif(date("Y-m-d")<$date_month){
                        $mark="";
                     }else{
                        $mark="0";
                        $absent++;
                     }

                     $list[$date_month]=array(
                         "is_present"=>$mark,
                         "start_time"=>@$is_checkin->start_time,
                         "start_location"=>@$is_checkin->start_location,
                         "end_time"=>@$is_checkin->end_time,
                         "end_time"=>@$is_checkin->end_time,

                     );

                }


                $result['status'] = 200;
                $result['success'] = true;
                $result['message'] = 'Attendance Sheet.';
                $result['present'] = $present;
                $result['absent'] = $absent;
                $result['working_days'] = $days_month;
                $result['data'] = $list;

            }else{

                $result['status'] = 500;
                $result['success'] = false;
                $result['message'] = 'Something went wrong.';

            }

            return $result;

            //return response()->json(['status' => 200, 'success' => true, 'properties' => $transformedProperties]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'success' => false, 'message' => $e->getMessage() . ', line no.: ' . $e->getLine()]);
        }
    }


}
