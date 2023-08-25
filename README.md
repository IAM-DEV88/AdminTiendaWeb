# Administrador de Tienda Web
![AdminTiendaWebUI](https://i.ibb.co/yVb7fys/Captura-de-pantalla-2023-08-25-115824.png)
Este código es una solución versátil para la gestión de ventas, ya sea en línea o en un punto de venta físico. Puede personalizarse para adaptarse a las necesidades específicas de tu negocio. A continuación, se detallan las características clave de esta aplicación:

# Caracteristicas principales
1. Gestión de Artículos
    - Permite una gestión eficiente de los artículos en tu tienda o inventario.
    - Búsqueda en Tiempo Real: Los usuarios pueden buscar y seleccionar artículos de manera dinámica mientras escriben en el campo de búsqueda.
    - Detalles de Artículos: Muestra información detallada de los artículos encontrados, incluyendo nombre, disponibilidad y valor.
    - Control de Disponibilidad: Verifica la disponibilidad de los artículos y muestra advertencias si la cantidad seleccionada es mayor que la disponibilidad.
    - Facturación Dinámica: Agrega los artículos seleccionados a una factura y actualiza la tabla de la factura en tiempo real.
    - Eliminación de Artículos: Permite eliminar artículos de la factura si es necesario.

2. Gestión de Clientes
    - Proporciona una funcionalidad similar para buscar y seleccionar clientes:
    - Detalles de Clientes: Muestra detalles de los clientes encontrados, incluyendo nombre, dirección, teléfono y correo electrónico.
    - Selección de Cliente: Permite seleccionar un cliente de la lista y muestra su información en un área dedicada.

3. Gestión de Proveedores
    - Proporciona una funcionalidad similar para buscar y seleccionar proveedores:
    - Detalles de Proveedores: Muestra detalles de los proveedores encontrados, incluyendo nombre, dirección, teléfono y correo electrónico.
    - Selección de Proveedor: Permite seleccionar un proveedor de la lista y muestra su información en un área dedicada.

3. Facturación
    - Cálculo Automático: Calcula el subtotal y el total de la factura a medida que se agregan o eliminan artículos.
    - Cambio: Facilita el cálculo del cambio cuando se ingresa el monto pagado por el cliente.
    - Registro de Ventas: Ofrece la opción de concretar la venta, imprimir la factura (simulado) y registrar la venta en el servidor a través de una solicitud AJAX.
    - Vaciar Factura: Proporciona la opción de vaciar la factura si se desea descartar la venta actual.

4. Barra de Estado
    - Mensajes de Estado: Muestra una barra de estado en la parte inferior de la página para proporcionar información y mensajes al usuario.
    - Notificaciones Temporales: Los mensajes de estado se muestran temporalmente y desaparecen automáticamente después de un tiempo, mejorando la experiencia del usuario.

5. Búsqueda de facturas por Fecha
    - Permite buscar registros de facturación por fecha:
    - Carga Dinámica: Los registros de facturación se cargan dinámicamente cuando se selecciona una fecha en el campo de filtro.
    - Lista de Resultados: Muestra la fecha de cada registro encontrado para una fácil referencia.

6. Visualización de Facturas
    - Cuando se selecciona una fecha de la lista de resultados, se muestra información detallada de la factura correspondiente:
    - Detalles de Factura: Muestra el nombre del cajero, la fecha de la factura y la información del cliente.
    - Lista de Productos: Los productos vendidos en la factura se muestran en una tabla con detalles como nombre del producto, cantidad, valor unitario y valor total. Además, se permite la anulación de productos.
    - Cálculos Automáticos: El código calcula automáticamente el total de la factura, considerando las cantidades anuladas.

7. Gestión de Garantías
    - Si hay garantías asociadas a la factura, se manejan en una sección separada:
    - Detalles de Garantía: Muestra la fecha de inicio de la garantía, el estado actual y la capacidad de agregar detalles a la garantía (si no está cerrada).
    - Operaciones: Las garantías se pueden cerrar, eliminar y actualizar con nuevos detalles según sea necesario.

8. Administración de Inventario
    - Búsqueda de Artículos en el Inventario
    - Los usuarios pueden buscar artículos en el inventario en tiempo real a medida que escriben en el campo de búsqueda. Los resultados de búsqueda se muestran en una lista desplegable debajo del campo de búsqueda e incluyen información relevante.

9. Selección de Artículo en el Inventario
    - Cuando un usuario hace clic en un artículo en la lista de resultados de búsqueda, se selecciona ese artículo y se cargan sus detalles en el formulario de edición. Esto incluye nombre del artículo, código de barras, cantidad disponible, valor y detalles del proveedor si están disponibles.

10. Actualización de Artículos
    - Los usuarios pueden actualizar los detalles de un artículo seleccionado, como su nombre, código de barras, cantidad disponible y valor. Los cambios se pueden guardar haciendo clic en el botón "Actualizar".

11. Eliminación de Artículos
    - Los usuarios pueden eliminar un artículo del inventario haciendo clic en el botón "Eliminar del inventario".

12. Agregar Artículos
    - Los usuarios pueden agregar nuevos artículos al inventario completando los campos requeridos y haciendo clic en el botón "Guardar".

13. Administración de Proveedores
    - Los usuarios pueden buscar proveedores en tiempo real a medida que escriben en el campo de búsqueda de proveedores. Los resultados de búsqueda se muestran en una lista desplegable debajo del campo de búsqueda e incluyen información relevante.

14. Selección de Proveedor
    - Cuando un usuario hace clic en un proveedor en la lista de resultados de búsqueda de proveedores, se selecciona ese proveedor y se muestran sus detalles en el formulario de edición. Esto incluye nombre del proveedor, dirección, teléfono y correo electrónico.

15. Validación de Campos
    - El código realiza una validación de campos antes de permitir que los usuarios guarden o actualicen información. Los campos vacíos se resaltan temporalmente y se muestra un mensaje de error en la parte superior si algún campo está incompleto.

16. Tabla de Inventario
    - Los datos del inventario se muestran en una tabla en la página web. Cada fila de la tabla representa un artículo del inventario y muestra información importante, como el número de artículo, nombre, cantidad disponible, valor, subtotal y una columna adicional denominada "extra".

17. Resumen de Inventario
    - En la parte superior de la tabla de inventario, se muestra un resumen que incluye el valor total del inventario, calculado como la suma de los subtotales de todos los artículos.

> Este sistema proporciona una solución integral para la gestión de ventas, facturas, inventario, clientes y proveedores.