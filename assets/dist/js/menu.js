$(document).ready(function() {

    $('#buscar-btn').on('click' , function(){
      preventDefault();
    buscarfecha();
    });
    $('#buscarlote').on('change' , function(){
    buscarfecha();
    });
    $('#buscarlote').on('keyup' , function(){
    buscarfecha();
    });

function buscarfecha() {
  var numero = document.getElementById('buscarlote').value;
  if (numero >= 1 && numero <= 366) {
  var mes = "";
  var dia = 0;
  if (numero >= 1 && numero <= 31) {
  mes = "enero";  dia = numero;    }
  if (numero >= 32 && numero <= 60)    {
  mes = "febrero";  dia = numero - 31; }
  if (numero >= 61 && numero <= 91)    {
  mes = "marzo";  dia = numero - 60; }
  if (numero >= 92 && numero <= 121)    {
  mes = "abril";  dia = numero - 91; }
  if (numero >= 122 && numero <= 152)    {
  mes = "mayo";  dia = numero - 121; }
  if (numero >= 153 && numero <= 182)    {
  mes = "junio";  dia = numero - 121; }
  if (numero >= 183 && numero <= 213)    {
  mes = "julio";  dia = numero - 182; }
  if (numero >= 214 && numero <= 244)   {
  mes = "agosto";  dia = numero - 213; }
  if (numero >= 245 && numero <= 274)   {
  mes = "septiembre";  dia = numero - 244; }
  if (numero >= 275 && numero <= 305)   {
  mes = "octubre";  dia = numero - 274; }
  if (numero >= 306 && numero <= 335)   {
  mes = "noviembre";  dia = numero - 305; }
  if (numero >= 336 && numero <= 366)   {
  mes = "diciembre";  dia = numero - 335; }

  $('#lote').show();
  $('#lote').html(dia + " de " + mes);
} else {
  $('#lote').html("lote incorrecto");
}

};
  });
