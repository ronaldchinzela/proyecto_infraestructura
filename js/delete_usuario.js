function confirma(e){
    if (confirm("¿Estás seguro de eliminar este usuario?")){
        return true;
    }else {
    e.preventDefault();
    }
}
let linkDelete = document.querySelectorAll(".link_js_eliminar_usuario");
for (var i = 0; i< linkDelete.length; i++){
    linkDelete[i].addEventListener('click', confirma);
}
<script> src="../delete_usuario.js"</script>