<?php
$username=$_GET['id'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Graph</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        #graph{
            width:1080px;
            height:auto;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <!-- <script src="js/app3.js"></script> -->
</head>
<body><?php include('adminheader.php');?>
<div id="graph">
<canvas id="chart3">
</canvas>
</div> 
<script>
    $(document).ready(function(){
    $.ajax({
        url:"http://localhost/hello/userlogic.php?name=<?php echo $username;?>",
        method:"GET",
        success:function(locationarr){
            console.log(locationarr);
            var username ="<?php echo $username;?>";
            var productname=[];
            var qty=[];
            for(var i in locationarr){
                productname.push(locationarr[i].product_name);
                qty.push(locationarr[i].total);
            }

            var chartdata ={
                labels:productname,
                datasets:[
                    {
                        label: username+ ' Sold',
                        backgroundColor: 'rgba(25,255,0,0.75)',
                        borderColor: 'rgba(200,200,200,0.75)',
                        hoverbackgroundColor: 'rgba(200,200,200,1)',
                        hoverborderColor: 'rgba(200,200,200,1)',
                        data:qty
                    }
                ]
            };
            var ctx=$('#chart3');
            var barGraph = new Chart(ctx,{
                type:"bar",
                data:chartdata
            });
        },
        error:function(locationarr){
            console.log(locationarr);
        }
    });
});
</script>  
</body>
</html>