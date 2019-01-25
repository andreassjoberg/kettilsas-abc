jQuery(function(){
(function($) {
    var weekDays = new Array("SU","MO","TU","WE","TH","FR","SA");
    var weekDaysLarge = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday","Friday", "Saturday");
    var monthsName = new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
    var prefixes = new Array("first", "second", "third", "fourth", "last");
    var recurring = {"startDate":new Date(),"endDate":new Date(),format:"",dateFormat:"mm/dd/yy"};
    if (!DateAdd || typeof (DateDiff) != "function") {
        var DateAdd = function(interval, number, idate) {
            number = parseInt(number);
            var date;
            if (typeof (idate) == "string") {
                date = idate.split(/\D/);
                eval("var date = new Date(" + date.join(",") + ")");
            }
    
            if (typeof (idate) == "object") {
                date = new Date(idate.toString());
            }
            switch (interval) {
                case "y": date.setFullYear(date.getFullYear() + number); break;
                case "m": date.setMonth(date.getMonth() + number); break;
                case "d": date.setDate(date.getDate() + number); break;
                case "w": date.setDate(date.getDate() + 7 * number); break;
                case "h": date.setHours(date.getHours() + number); break;
                case "n": date.setMinutes(date.getMinutes() + number); break;
                case "s": date.setSeconds(date.getSeconds() + number); break;
                case "l": date.setMilliseconds(date.getMilliseconds() + number); break;
            }
            return date;
        }
    }
    function weekAndDay(date) {
          return (0 | (date.getDate()-1) / 7);
    }
    timeToUntilString= function(time) {
        var date = new Date(time);
        var comp, comps = [
            date.getUTCFullYear(),
            date.getUTCMonth() + 1,
            date.getUTCDate(),
            'T',
            date.getUTCHours(),
            date.getUTCMinutes(),
            date.getUTCSeconds(),
            'Z'
        ];
        for (var i = 0; i < comps.length; i++) {
            comp = comps[i];
            if (!/[TZ]/.test(comp) && comp < 10) {
                comps[i] = '0' + String(comp);
            }
        }
        return comps.join('');
    }
    loadRepeatData = function()
    {
        var data = recurring.format;
        var startdate = recurring.startDate;
        var enddate = recurring.endDate;
        for (var i=1;i<=30;i++)
            $("#interval").append('<option value="'+i+'">'+i+'</option>');
        for (var i=2;i<100;i++)
            $("#end_after").append('<option value="'+i+'">'+i+'</option>');
        $("#end_after").val(5);
        var currentDate = startdate;
        $("#starts").html($.datepicker.formatDate(recurring.dateFormat,startdate)+" "+startdate.getHours()+":"+((startdate.getMinutes()<10)?"0":"")+startdate.getMinutes());
        $("#end_until_input").datepicker({dateFormat:recurring.dateFormat,onSelect: function(date) {
            $("#end_until").prop( "checked", true );
            $("#end_until").trigger( "change" );
        }})
        $("#end_until_input").val($.datepicker.formatDate(recurring.dateFormat,enddate));    
        if (data == "")
            data = "FREQ=WEEKLY;BYDAY="+weekDays[currentDate.getDay()]+"";
        var v_freq = 10;
        var d = data.split(";");
        for (var i=0;i<d.length;i++)
        {
            var dd = d[i].split("=");
            d[i] = {k:dd[0],v:dd[1]};
        }
        for (var i=0;i<d.length;i++)
        {
            switch(d[i].k)
            {
                case "FREQ":
                      switch(d[i].v)
                      {
                          case "DAILY":
                              v_freq = 0;
                          break;
                          case "WEEKLY":
                              v_freq = 4;
                          break;
                          case "MONTHLY":
                              v_freq = 5;
                          break;
                          case "YEARLY":
                              v_freq = 6;
                          break;
                      }
                break;
                case "INTERVAL":
                    $("#interval").val(d[i].v);
                break;
                case "BYDAY":
                      var dd = d[i].v.split(",");
                      var sample1 = ["MO","TU","WE","TH","FR"]; //Every weekday (Monday to Friday) // ["MO","TU","WE","TH","FR"];
                      if ($(dd).not(sample1).length == 0 && $(sample1).not(dd).length == 0)
                          v_freq = 1;
                      var sample2 = ["MO","WE","FR"]; //Every Monday, Wednesday, and Friday // ["MO","WE","FR"];
                      if ($(dd).not(sample2).length == 0 && $(sample2).not(dd).length == 0)
                          v_freq = 2;
                      var sample3 = ["TU","TH"]; //Every Tuesday, and Thursday // ["TU","TH"];
                      if ($(dd).not(sample3).length == 0 && $(sample3).not(dd).length == 0)
                          v_freq = 3;
                      for (j = 0; j < dd.length; j++) {
                          day = dd[j];
                          if (day.length == 2) { // MO, TU, ... instanceof Weekday
                              $("#byday"+dd[j]).attr("checked","checked");
                          } else { // -1MO, +3FR, 1SO, ... instanceof MONTHLY, YEARLY
                              day = day.match(/^([+-]?\d)([A-Z]{2})$/);
                              n = Number(day[1]);
                              wday = day[2];
                              $("#byday_w").attr("checked","checked");
                          }
                      }
                      for (var j=0;j<dd.length;j++)
                          $("#byday"+dd[j]).attr("checked","checked");
                break;
                case "COUNT":
                    $("#end_count").attr("checked","checked");
                    $("#end_after").val(d[i].v);
                break;
                case "UNTIL":
                    var day = /(\d{4})(\d{2})(\d{2})T(\d{2})(\d{2})(\d{2})Z/.exec(d[i].v);
                    var until = new Date(Date.UTC(day[1], day[2] - 1,day[3], day[4], day[5], day[6]));
                    $("#end_until").attr("checked","checked");
                    $("#end_until_input").val((until.getMonth()+1)+"/"+until.getDate()+"/"+until.getFullYear());
                break;
                case "BYMONTHDAY":
                case "BYMONTH":
                    $("#byday_m").attr("checked","checked");
                break;
            }
        }
        summaryDisplay = function()
        {
            var v = parseInt($("#freq").val());
            var summary = "";
            var format = "";
            switch(v)
            {
                case 0:
                    format += "FREQ=DAILY";
                    if ($("#interval").val()==1)
                        summary += "Daily";
                    else
                    {
                        summary += "Every "+$("#interval").val()+" days" ;
                        format += ";INTERVAL="+$("#interval").val();
                    }    
                break;
                case 1:
                    format += "FREQ=WEEKLY;BYDAY=MO,TU,WE,TH,FR";
                    summary += "Weekly on weekdays";
                break;
                case 2:
                    format += "FREQ=WEEKLY;BYDAY=MO,WE,FR";
                    summary += "Weekly on Monday, Wednesday, Friday";
                break;
                case 3:
                    format += "FREQ=WEEKLY;BYDAY=TU,TH";
                    summary += "Weekly on Tuesday, Thursday";
                break;
                case 4:
                    format += "FREQ=WEEKLY";
                    for (var i=0;i<weekDays.length;i++)
                    {
                        if ($("#byday"+weekDays[i]).is(":checked"))
                        {
                            if (summary =="")
                            {
                                summary += " on ";
                                format += ";BYDAY=";
                            }
                            else
                            {
                                summary += ", ";
                                format += ",";
                            }
                            summary += weekDaysLarge[i];
                            format += weekDays[i];
                        }
                    }
                    if ($("#interval").val()==1)
                        summary = "Weekly"+summary;
                    else
                    {
                        summary = "Every "+$("#interval").val()+" weeks"+summary;
                        format += ";INTERVAL="+$("#interval").val();
                    }
                break;
                case 5:
                    format += "FREQ=MONTHLY";
                    if ($("#byday_m").is(":checked"))
                    {
                        summary += " on day "+currentDate.getDate();
                        format += ";BYMONTHDAY="+currentDate.getDate();
                    }
                    else
                    {
                        summary += " on the "+prefixes[weekAndDay(currentDate)]+ " " +weekDaysLarge[currentDate.getDay()];
                        format += ";BYDAY="+(weekAndDay(currentDate)==4?-1:(weekAndDay(currentDate)+1))+weekDays[currentDate.getDay()];
                    }
                    if ($("#interval").val()==1)
                        summary = "Monthly"+summary;
                    else
                    {
                        summary = "Every "+$("#interval").val()+" months"+summary;
                        format += ";INTERVAL="+$("#interval").val();
                    }
                break;
                case 6:
                    format += "FREQ=YEARLY;BYMONTH="+(currentDate.getMonth()+1);
                    if ($("#byday_m").is(":checked"))
                    {
                        summary += " on " + monthsName[currentDate.getMonth()] + " " + currentDate.getDate();
                    }
                    else
                    {
                        summary += " on " + monthsName[currentDate.getMonth()] + ", "+prefixes[weekAndDay(currentDate)]+ " " +weekDaysLarge[currentDate.getDay()];
                        format += ";BYDAY="+(weekAndDay(currentDate)+1)+weekDays[currentDate.getDay()];
                    }
                    if ($("#interval").val()==1)
                        summary = "Annually"+summary;
                    else
                    {
                        summary = "Every "+$("#interval").val()+" years"+summary;
                        format += ";INTERVAL="+$("#interval").val();
                    }
                break;
            }
            if ($("#end_count").is(":checked"))
            {
                if (parseInt($("#end_after").val())==1)
                    summary = "Once";
                else
                {
                    summary += ", "+$("#end_after").val()+" times";
                    format += ";COUNT="+$("#end_after").val();
                }
            }
            else if ($("#end_until").is(":checked"))
            {
                if ($("#end_until_input").val()!="")
                {
                    var endDate = $("#end_until_input").datepicker( "getDate" );
                    endDate = new Date(endDate.getTime()+24*60*60*1000-1000)
                    recurring.endDate = endDate;
                    summary += ", until " + monthsName[endDate.getMonth()] + " " + endDate.getDate() + ", " + endDate.getFullYear();
                    format += ";UNTIL="+timeToUntilString(endDate);
                }
            }
            $("#summary").html(summary);
            $("#format").val(format);
            if ($("#format").val()=="")
            {
                $("#repeatspan").html("");
                $("#repeatcheckbox").attr("checked","");
            }
            else
            {
                $("#repeatspan").html(summary);
                $("#repeatcheckbox").attr("checked","checked");
            }
    
            var list = getRepeatList();
            if (!$("#end_count").is(":checked"))
            {
                $("#end_after").val(list.length+1);
            }
            else 
            {
                $("#end_until_input").val($.datepicker.formatDate(recurring.dateFormat,list[list.length-1]));
            }
    
        }
        changeDisplay = function(v)
        {         
            if (v==10)
            {
                $("#repeatOptions").css("display","none"); 
                return;
            } 
            else
                $("#repeatOptions").css("display","block");   
            if (v==1 || v==2 || v==3)
                $("#intervaldiv").css("display","none");
            else
            {
                $("#intervaldiv").css("display","block");
                if (v==0)  $("#interval_label").html("days");
                else if (v==4)  $("#interval_label").html("weeks");
                else if (v==5)  $("#interval_label").html("months");
                else if (v==6)  $("#interval_label").html("years");
            }
            if (v==4)
                $("#bydayweek").css("display","block");
            else
                $("#bydayweek").css("display","none");  //none
            if (v==5 || v==6)
                $("#bydaymonth").css("display","block");
            else
                $("#bydaymonth").css("display","none");
            summaryDisplay();
    
        }
        getRepeatList = function()
        {
            var options = RRule.parseString($("#format").val());
            options.dtstart = recurring.startDate;
            var r = new RRule(options);
            var ne = r.between( recurring.startDate,new Date(3000, 0, 1));
            var str = "";
            for (var i=0;i<ne.length;i++)
            {
                var hour = ne[i].getHours();
                var timead = '';
                if (cpabc_global_military_time == '0')
                {
                    if (parseInt(hour) > 12)
                    {
                        timead = " pm";
                        hour = parseInt(hour)-12;
                    }
                    else
                        timead = " am";
                }
                var minutes = ne[i].getMinutes();
                if (minutes < 10)
                    minutes = "0"+minutes;
                sel_fdate = " "+hour+":"+minutes+timead;
                if (cpabc_global_date_format == '1')
                    sel_fdate = ne[i].getDate() + "/" + (ne[i].getMonth()+ 1) +"/" + ne[i].getFullYear() + sel_fdate;
                else if (cpabc_global_date_format == '2')
                    sel_fdate = ne[i].getDate() + "." + (ne[i].getMonth()+ 1) +"." + ne[i].getFullYear() + sel_fdate;
                else  
                    sel_fdate = (ne[i].getMonth()+ 1) + "/" + ne[i].getDate() +"/" + ne[i].getFullYear() + sel_fdate;                
                str += "<div>"+(i+1)+". " + sel_fdate+"</div>";
            }            
            $("#repeatList").html(str);
            var str = "";
            for (var i=0;i<ne.length;i++)
            {
                str += ";"+ne[i].getFullYear() + "," + (ne[i].getMonth()+ 1) +"," + ne[i].getDate() + " " + ne[i].getHours() + ":" + ((ne[i].getMinutes()<10)?"0":"")+ne[i].getMinutes();      
            }
            $("#selMonthcal"+cpabc_current_calendar_item).val(str);
            return ne;
            
        }
    
        //$("#freq").val(v_freq);
        //changeDisplay(v_freq);
    
        $("#freq").change(function(){
            if ($(this).val()==10)
            {
                $("#repeatOptions").css("display","none");
                $("#repeatList").html("");
            }
            else
            {
                $("#repeatOptions").css("display","block");
                changeDisplay($(this).val());
            }
            
        });
        $("#interval").change(function(){
            summaryDisplay();
        });
        $("#end_never").change(function(){
            summaryDisplay();
        });
        $("#end_count").change(function(){
            summaryDisplay();
        });
        $("#end_until").change(function(){
            summaryDisplay();
        });
        $("#end_after").change(function(){
            summaryDisplay();
        });
        $("#end_until_input").change(function(){
            summaryDisplay();
        });
        $(".bydayw").change(function(){
            summaryDisplay();
        });
        $(".bydaym").click(function(){
            summaryDisplay();
        });
    }
    $("#selDaycal"+cpabc_current_calendar_item).change(function(){
        if ($(this).val()!="")
        {
            var v = $(this).val();
            v = v.split(";");
            if (v.length>1)
            {  
                var d0 = v[1].split(",");
                var d1 = d0[2].split(" ");
                var d2 = d1[1].split(":"); 
                var d = new Date(parseInt(d0[0]),parseInt(d0[1])-1,parseInt(d1[0]),parseInt(d2[0]),parseInt(d2[1]));
                $("#repeat").css("display","block");
                recurring = {"startDate":d,"endDate":DateAdd("m", 1, d),format:$("#format").val(),dateFormat:recurring.dateFormat};
                loadRepeatData();
                summaryDisplay();
                return;
            }
        }
        $("#repeat").css("display","none");
        $("#selMonthcal"+cpabc_current_calendar_item).val("");
        
    });
})(jQuery);
});