<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" >

    <title>GRAFICO DE CHARTJS</title>
  </head>
  <body>
       <div class="col-lg-12" style="padding-top:20px;">
           <div class="card">
            <div class="card-header">
                GRAFICO CON CHARTJS 
            </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <canvas id="graficobar" width="400" height="400"></canvas> 
                            </div>
                            <div class="col-lg-4">
                                <canvas id="graficobarhorizontal" width="400" height="400"></canvas>  
                            </div>
                            <div class="col-lg-4">
                               <canvas id="graficopie" width="400" height="400"></canvas>
                            </div>
                        </div>
                    </div>
            </div>


            <div class="card">
            <div class="card-header">
                GRAFICO CON CHARTJS CON PARAMETROS
            </div>
                    <div class="card-body">
                        <div class="row">
                           <div class="col-lg-5">
                                <label for="">Fecha inicio</label>
                                <select name="" id="select_finicio" class= "form-control"></select>
                           </div>
                           <div class="col-lg-5">
                                <label for="">Fecha fin</label>
                                <select name="" id="select_ffin" class= "form-control"></select>
                           </div>
                           <div class="col-lg-2">
                                <label for="">&nbsp;</label><br>
                                <button class = "btn btn-danger" onclick = "CargarGraficosParametro()">BUSCAR</button>
                           </div>
                            <div class="col-lg-4">
                                <canvas id="graficodoughnut_parametro" width="400" height="400"></canvas> 
                            </div>
                            <div class="col-lg-4">
                                <canvas id="graficopolararea_parametro" width="400" height="400"></canvas>  
                            </div>
                            <div class="col-lg-4">
                               <canvas id="graficoscatter_parametro" width="400" height="400"></canvas>
                            </div>
                        </div>       
                    </div>
            </div>
       </div>
        
  </body>
</html>
   
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" ></script>
    <script>

    CargarDatosGraficoBar();
    CargarDatosGraficoBarHorizontal();
    CargarDatosGraficopie();
    

    function CargarDatosGraficoBar(){
          $.ajax({
              url:"controlador_grafico.php",
              type:"POST"
          }).done(function(resp){
            if(resp.length>0){
                var titulo   = [];
                var cantidad =[];
                var colores  =[];
                var data = JSON.parse(resp);  
                for(var i=0; i< data.length; i++){
                        titulo.push(data[i][1]); 
                        cantidad.push(data[i][2]); 
                        colores.push(colorRGB());
                }

                CrearGrafico(titulo,cantidad,colores,'bar', 'GRAFICO EN BARRAS DE PRODUCTOS','graficobar');
              }    
          })
    }
    function CargarDatosGraficoBarHorizontal(){
          $.ajax({
              url:"controlador_grafico.php",
              type:"POST"
          }).done(function(resp){
              if(resp.length>0){
                var titulo   = [];
                var cantidad =[];
                var colores  =[];
                var data = JSON.parse(resp);  
                for(var i=0; i< data.length; i++){
                        titulo.push(data[i][1]); 
                        cantidad.push(data[i][2]);
                        colores.push(colorRGB()); 
                }

                CrearGrafico(titulo,cantidad,colores,'horizontalBar', 'GRAFICO EN BARRAS HORIZONTAL DE PRODUCTOS','graficobarhorizontal');
              }   
          })
    }

    function CargarDatosGraficopie(){
          $.ajax({
              url:"controlador_grafico.php",
              type:"POST"
          }).done(function(resp){
              if(resp.length>0){
                var titulo   = [];
                var cantidad =[];
                var colores  =[];
                var data = JSON.parse(resp);  
                for(var i=0; i< data.length; i++){
                        titulo.push(data[i][1]); 
                        cantidad.push(data[i][2]);
                        colores.push(colorRGB()); 
                }

                CrearGrafico(titulo,cantidad,colores,'pie', 'GRAFICO PIE  DE PRODUCTOS','graficopie');
              }   
          })
    }


    function generarNumero(numero){
	return (Math.random()*numero).toFixed(0);
    }

    function colorRGB(){
        var coolor = "("+generarNumero(255)+"," + generarNumero(255) + "," + generarNumero(255) +")";
        return "rgb" + coolor;
    }

    TraerAnio();
    function CargarGraficosParametro(){
        CargarDatosGraficoDoughnut();
        CargarDatosGraficoPolar();
        CargarDatosGraficoScatter();
    }
    function TraerAnio(){
        var mifecha = new Date();
        var anio = mifecha.getFullYear();
        var cadena = "";
        for(var i=2015; i<anio+1; i++){
            cadena+="<option value= "+i+">"+i+"</option>";
        }
        $("#select_finicio").html(cadena);
        $("#select_ffin").html(cadena);
    }

    function CargarDatosGraficoDoughnut(){
        var fechainicio = $("#select_finicio").val();
        var fechafin = $("#select_ffin").val();
          $.ajax({
              url:"controlador_grafico_parametro.php",
              type:"POST",
              data:{
                  inicio:fechainicio,
                  fin:fechafin
              }
          }).done(function(resp){
            if(resp.length>0){
                var titulo   = [];
                var cantidad =[];
                var colores  =[];
                var data = JSON.parse(resp);  
                for(var i=0; i< data.length; i++){
                        titulo.push(data[i][0]); 
                        cantidad.push(data[i][1]); 
                        colores.push(colorRGB());
                }

                CrearGrafico(titulo,cantidad,colores,'doughnut', 'GRAFICO DOUGHNUT DE PRODUCTOS','graficodoughnut_parametro');
              }    
          })
    }

    function CargarDatosGraficoPolar(){
        var fechainicio = $("#select_finicio").val();
        var fechafin = $("#select_ffin").val();
          $.ajax({
              url:"controlador_grafico_parametro.php",
              type:"POST",
              data:{
                  inicio:fechainicio,
                  fin:fechafin
              }
          }).done(function(resp){
            if(resp.length>0){
                var titulo   = [];
                var cantidad =[];
                var colores  =[];
                var data = JSON.parse(resp);  
                for(var i=0; i< data.length; i++){
                        titulo.push(data[i][0]); 
                        cantidad.push(data[i][1]); 
                        colores.push(colorRGB());
                }

                CrearGrafico(titulo,cantidad,colores,'polarArea', 'GRAFICO POLARAREA DE PRODUCTOS','graficopolararea_parametro');
              }    
          })
    }

    function CargarDatosGraficoScatter(){
        var fechainicio = $("#select_finicio").val();
        var fechafin = $("#select_ffin").val();
          $.ajax({
              url:"controlador_grafico_parametro.php",
              type:"POST",
              data:{
                  inicio:fechainicio,
                  fin:fechafin
              }
          }).done(function(resp){
            if(resp.length>0){
                var titulo   = [];
                var cantidad =[];
                var colores  =[];
                var data = JSON.parse(resp);  
                for(var i=0; i< data.length; i++){
                        titulo.push(data[i][0]); 
                        cantidad.push(data[i][1]); 
                        colores.push(colorRGB());
                }

                CrearGrafico(titulo,cantidad,colores,'line', 'GRAFICO SCATTERAREA  DE PRODUCTOS','graficoscatter_parametro');
              }    
          })
    }



    function CrearGrafico(titulo,cantidad,colores,tipo,encabezado,id){
        var ctx = document.getElementById(id);
              var myChart = new Chart(ctx, {
                type: tipo,
                data: {
                    labels: titulo,
                    datasets: [{
                        label: encabezado,
                        data: cantidad,
                        backgroundColor:colores,
                        borderColor:colores,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
    }
    </script>
    