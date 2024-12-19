@extends('layouts.app')

@section('app')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
          
               <div class="row" style="backgorund-color: #fff; border-radius: 5px;margin-bottom:10px; ">
                     <div class="col-md-12 ">
                        <b class="city" style="font-weight:bold;font-size:18px;">Period No -<span id="period_no"></span></b>
                    </div>
               

                     <div class="col-md-3">
                         <h4 id="result_announce_time"></h4>
                     </div>
                   <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <h4 id="timer"></h4>
                    </div>
               </div>
    
             <form id="filterForm" action="{{route('game_setting')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-1">
            <h5 class="city">Status</h5>
        </div>
        <div class="col-md-1">
            <select id="status" name="status">
                <option value="1" {{$game_settings->status==1?'selected':''}}>On</option>
                <option value="2" {{$game_settings->status==2?'selected':''}}>Off</option>
            </select>
        </div>
        
        <div class="col-md-1">
            <h5 class="city">Result</h5>
        </div>
        <div class="col-md-2">
            <select id="result-type" class="form-control" name="result">
                <option value="1" {{$game_settings->result_type==1?'selected':''}}>Manual</option>
                <option value="2" {{$game_settings->result_type==2?'selected':''}}>Lucky Draw</option>
                <option value="3" {{$game_settings->result_type==3?'selected':''}}>Auto</option>
            </select>
        </div>

        <div class="col-md-1">
            <h5 class="city">Win %</h5>
        </div>
        <div class="col-md-1">
            <select id="winning-percentage" name="percentage">
                <option value="25" {{$game_settings->winning_per==25?'selected':''}}>25-50</option>
                <option value="50" {{$game_settings->winning_per==50?'selected':''}}>50-75</option>
                <option value="75" {{$game_settings->winning_per==75?'selected':''}}>75-100</option>
                <option value="100" {{$game_settings->winning_per==100?'selected':''}}>100-125</option>
            </select>
        </div>

        <div class="col-md-1">
           
        </div>
        
        <div class="col-md-2">
            <h5>Site Msg</h5>
            <textarea id="textarea_id" rows="2" cols="20" name="site_message" placeholder="site msg">{{$game_settings->site_message}}</textarea>
        </div>

        <div class="col-md-1 ml-5">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>


          
          <!--<div class="row" style="padding-top: 2px;">-->
          <!--  @for($i = 1; $i <= 12; $i++)-->
          <!--      <div class="card border col-md-1 mt-4" style="height:50px;">-->
          <!--          <h1>{{ $i }}</h1>-->
          <!--      </div>-->
          <!--  @endfor-->

          <!--</div>-->
          <div class="row" style="padding-bottom:20px;">
                <div class="card border col-md-1  mt-4" style="height:90px;"><img src="{{asset('/images/1.png')}}"></div>
                <div class="card border col-md-1  mt-4" style="height:90px;"><img src="{{asset('/images/2.png')}}"></div>
                <div class="card border col-md-1  mt-4" style="height:90px;"><img src="{{asset('/images/3.png')}}"></div>
                <div class="card border col-md-1  mt-4" style="height:90px;"><img src="{{asset('/images/4.png')}}"></div>
                <div class="card border col-md-1  mt-4" style="height:90px;"><img src="{{asset('/images/5.png')}}"></div>
                <div class="card border col-md-1  mt-4" style="height:90px;"><img src="{{asset('/images/6.png')}}"></div>
                
                <div class="card border col-md-1  mt-4" style="height:90px;"><img src="{{asset('/images/7.png')}}"></div>
                <div class="card border col-md-1  mt-4" style="height:90px;"><img src="{{asset('/images/8.png')}}"></div>
                <div class="card border col-md-1  mt-4 " style="height:90px;"><img src="{{asset('/images/9.png')}}"></div>
                <div class="card border col-md-1 mt-4 " style="height:90px;"><img src="{{asset('/images/10.png')}}"></div>
                <div class="card border col-md-1  mt-4 " style="height:90px;"><img src="{{asset('/images/11.png')}}"></div>
                <div class="card border col-md-1 mt-4 " style="height:90px;"><img src="{{asset('/images/12.png')}}"></div>
          </div>
       
           
         <div class="row" style="padding-top: 2px;">
    @for($i = 1; $i <= 12; $i++)
        <div class="card border col-md-1 mt-4" style="height:50px;">
            <h1>{{ $i }}</h1>
            <p> <span id="amount-{{ $i }}">0</span></p> <!-- Placeholder for amount -->
        </div>
    @endfor
</div>


           
           
           <div class="row d-flex justify-content-center align-items-center" style="padding-bottom:20px;background-color:white;">
               <div class="col-md-2" style="border:1px solid blue;color:black;font-weight:400;width:100%;height:40px">Total Purchase Points - </div>
                <div class="col-md-2" style="border:1px solid blue;color:black;font-weight:400;width:100%;height:40px" id="toatlPurchaseTicket"></div>
                <div class="col-md-3" style="border:1px solid blue;color:black;font-weight:400;width:100%;height:40px">System max winning points - </div>
                <div class="col-md-2" style="border:1px solid blue;color:black;font-weight:400;width:100%;height:40px" id="maxSystemWinning"></div>
                <div class="col-md-3"></div>
           </div>
               
          <form action="{{route('admin_prediction')}}" method="post">
            @csrf
               <!--important input box hidden for prediction insert and also works for custom date selection-->
             <input type="hidden" class="form-control" id="result_time" style="  font-size: 16px;color:#333;border:none" name="result_time" value="">
                   <div class="row ml-4 d-flex" style="margin-bottom: 20px;"> 
                   <div class="col-md-3 form-group d-flex">
                       <p style="color: #000000;font-weight:500;">select date & time only for upcoming prediction, no need for current time prediction - </p>
                   </div>
                        <div class="col-md-3 form-group d-flex">
                           
                            <input type="text" name="period_no" class="form-control"  id="period_no_input">
                           

                         </div>
                          
                            @error('period_no')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                         
                         
                         
                         <div class="col-md-2 form-group d-flex">
                             <input type="number" name="number" class="form-control" min="1" max="12" placeholder="Result" id="result-number" required>
                             
                         </div>
                         @error('number')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                         <div class="col-md-2 form-group d-flex">
                            <button type="submit" class="form-control btn btn-info" id="submit-button"><b>Submit</b></button>
                         </div>
                         <div class="col-md-2 form-group d-flex mt-1">
                            <a href=""> <i class="fa fa-refresh" aria-hidden="true" style="font-size:30px;"></i></a>
                         </div>
                   </div>
           </form>
           
       
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Function to fetch the latest bet logs
        function fetchLatestBetLogs() {
            $.ajax({
                url: '/api/lucky12-betlogs', // Your API route
                method: 'GET',
                success: function(response) {
                    // Update your dashboard with the latest data
                   
                    $('#period_no').text(response.period_no);
                    $('#period_no_input').val(response.period_no);
                   
                 
                    
                   
                },
                error: function() {
                    console.log('Error fetching bet logs');
                }
            });
        }

        // Call the function when the page loads
        fetchLatestBetLogs();

        // Set an interval to fetch data every 5 seconds (or as needed)
        setInterval(fetchLatestBetLogs, 5000);
    });
</script>


<script>
    $(document).ready(function() {
        // Function to fetch the latest bet logs
        function fetchLatestBetLogs() {
            $.ajax({
                url: '/api/lucky12-betlogs-amount', // Your API route
                method: 'GET',
                success: function(response) {
                    // Loop through the response and display amount for each matching number
                    response.forEach(function(betLog) {
                        $('#amount-' + betLog.number).text(betLog.amount);
                    });
                },
                error: function() {
                    console.log('Error fetching bet logs');
                }
            });
        }

        // Call the function when the page loads
        fetchLatestBetLogs();

        // Set an interval to fetch data every 5 seconds (or as needed)
        setInterval(fetchLatestBetLogs, 5000);
    });
</script>




<script type="text/javascript">    
    setInterval(page_refresh, 1*60000); //NOTE: period is passed in milliseconds
</script>
           
           
           


        </div>
        </div>
        </div>
     </div>

@endsection