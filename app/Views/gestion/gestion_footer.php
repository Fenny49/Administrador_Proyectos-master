<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userTableContainer = document.getElementById('user-table');
        const groupTableContainer = document.getElementById('group-table');
        const showUsersBtn = document.getElementById('show-users');
        const showGroupsBtn = document.getElementById('show-groups');

        function toggleTables() {
            // Comprueba qué botón de radio está seleccionado
            if (showUsersBtn.checked) {
                userTableContainer.style.display = 'block'; // Muestra la tabla de usuarios
                groupTableContainer.style.display = 'none';  // Oculta la tabla de grupos
            } else {
                userTableContainer.style.display = 'none';   // Oculta la tabla de usuarios
                groupTableContainer.style.display = 'block';  // Muestra la tabla de grupos
            }
        }

        // Añade un "oyente" a los botones para que llamen a la función cuando se haga clic
        showUsersBtn.addEventListener('change', toggleTables);
        showGroupsBtn.addEventListener('change', toggleTables);

        // Llama a la función una vez al cargar la página para establecer el estado inicial
        toggleTables();
    });
</script>

</body>
</html>