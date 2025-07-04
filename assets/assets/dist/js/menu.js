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
  if (numero >= 1 && numero <= 365) {
  var mes = "";
  var dia = 0;
  if (numero >= 1 && numero <= 31) {
  mes = "enero";  dia = numero;    }
  if (numero >= 32 && numero <= 59)    {
  mes = "febrero";  dia = numero - 31; }
  if (numero >= 60 && numero <= 90)    {
  mes = "marzo";  dia = numero - 59; }
  if (numero >= 91 && numero <= 120)    {
  mes = "abril";  dia = numero - 90; }
  if (numero >= 121 && numero <= 151)    {
  mes = "mayo";  dia = numero - 120; }
  if (numero >= 152 && numero <= 181)    {
  mes = "junio";  dia = numero - 120; }
  if (numero >= 182 && numero <= 212)    {
  mes = "julio";  dia = numero - 181; }
  if (numero >= 213 && numero <= 243)   {
  mes = "agosto";  dia = numero - 212; }
  if (numero >= 244 && numero <= 273)   {
  mes = "septiembre";  dia = numero - 243; }
  if (numero >= 274 && numero <= 304)   {
  mes = "octubre";  dia = numero - 273; }
  if (numero >= 305 && numero <= 334)   {
  mes = "noviembre";  dia = numero - 304; }
  if (numero >= 335 && numero <= 365)   {
  mes = "diciembre";  dia = numero - 334; }

  $('#lote').show();
  $('#lote').html(dia + " de " + mes);
} else {
  $('#lote').html("lote incorrecto");
}

};
  });
