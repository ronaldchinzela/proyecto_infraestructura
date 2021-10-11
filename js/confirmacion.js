//creando alerta para la confirmación de un elemento a eliminar
function confirmacion(evento){
    if (confirm("¿Estás seguro de eliminar este SOW?")) {
        return true;
    }else{
        evento.preventDefault();
    }
}

let linkDelete = document.querySelectorAll(".link_js_eliminar");

//creando for que cuente los elementos seleccionados
for (var i = 0; i < linkDelete.length; i++){
    linkDelete[i].addEventListener('click', confirmacion);
}
