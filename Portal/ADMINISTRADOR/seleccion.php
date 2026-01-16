<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marcar y desmarcar todos los checkbox de formulario con un botón</title>
    </head>
    <body>
        
    <form name="f1" id="formElement">
        <p>
            Nombre: <input type="text" name="nombre" />
            <br>
            <input type="checkbox" name="ch1" /> Opcion 1
            <br>
            <input type="checkbox" name="ch2" /> Opcion 2
            <br>
            <input type="checkbox" name="ch3" /> Opcion 3
            <br>
            <input type="checkbox" name="ch4" /> Opcion 4
            <br>
            <select name="otro">
                <option value="1">Seleccion 1</option>
                <option value="2">Seleccion 2</option>
            </select>
            <br>
            <input type="submit" value="Enviar" />
        </p>
        <p>
            <a href="#" id="marcarTodo">Marcar todos los checkbox</a> |
            <a href="#" id="desmarcarTodo">Desmarcar todos los checkbox</a>
        </p>
    </form>
    
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('marcarTodo').addEventListener('click', function(e) {
                e.preventDefault();
                //seleccionarTodo();
                checkAll();
            });
            document.getElementById('desmarcarTodo').addEventListener('click', function(e) {
                e.preventDefault();
                //desmarcarTodo();
                uncheckAll();
            });
        });
    
        function seleccionarTodo() {
            for (let i=0; i < document.f1.elements.length; i++) {
                if(document.f1.elements[i].type === "checkbox") {
                    document.f1.elements[i].checked = true;
                }
            }
        }
    
        function desmarcarTodo() {
            for (let i=0; i<document.f1.elements.length; i++) {
                if(document.f1.elements[i].type == "checkbox") {
                    document.f1.elements[i].checked = false
                }
            }
        }
    
        function checkAll() {
            document.querySelectorAll('#formElement input[type=checkbox]').forEach(function(checkElement) {
                checkElement.checked = true;
            });
        }
    
        function uncheckAll() {
            document.querySelectorAll('#formElement input[type=checkbox]').forEach(function(checkElement) {
                checkElement.checked = false;
            });
        }
    </script>
    </body>
    </html>