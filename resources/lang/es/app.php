<?php

return [
    //Color
    'delete_color' => 'rgb(59, 87, 75)',

    //Controllers message
    'error_create'=>  'Hubo un error al crear el :object',
    'error_update'=>  'Hubo un error al actualizar el :object',
    'error_delete'=>  'Hubo un error interno',
    'error_delete_integrity'=>  'El registro seleccionado no puede ser eliminado porque está asociado a otros elementos en el sistema',
    'error_select'=>  'Debe de seleccionar una opción',
    'error_tour_exist_guide'=>  'El guía ya existe en el tour',
    'error_tour_exist_client'=>  'El cliente ya existe en el tour',
    'error_not_found'=>  'El :object que busca no se encuentra',
    'success_create '=> 'Se ha creado con éxito el :object',
    'success_update '=> 'Se ha actualizado con éxito el :object',
    'success'=> 'Exitoso',

    //Error page
    'error_exchange_rate_tittle'=>  'No se ha creado un tipo de Cambio para el dia de Hoy',

    //login
    'login_msg1' => 'Bienvenido a Jungle Life 👋',
    'login_msg2' => 'Inicie sesión en su cuenta y comience la aventura',
    'login_mail' => 'Correo',
    'login_pass' => 'Contraseña',
    'login_forgot' => '¿Olvidó la contraseña?',
    'login_remember' => 'Recordarme',
    'login_btn' => 'Ingresar',

    //login Fail
    'not_active' => 'Usuario no se encuentra activo',
    'throttled' => 'Demasiados intentos de inicio de sesión. Por favor, inténtelo de nuevo en :time  segundos ',
    'user_error' => 'Nombre de usuario o contraseña incorrectos',

    //Reset Password
    'reset_msg1' => 'Restablecer contraseña',
    'reset_go_Login' => 'Volver al inicio de sesión',
    'reset_btn' => 'Solicitar restablecer contraseña',
    'mail.error' => 'El correo es incorrecto',
    'send.email' => 'Se ha enviado el correo de restablecer la contraseña',
    'confirm.reset.btn' => 'Restablecer',
    'login_pass.confirm' => 'Confirmar contraseña',

    //Password Reset Admin
    'admin_reset_text' => 'Que desea resetear la contraseña de ',
    'admin_success_tittle' => 'Ok',
    'admin_success_message' => 'Se ha enviado el correo para restablecer la contraseña',
    'admin_error_message' => 'Hubo un error al intentar reiniciar la contraseña',

    //Mail template
    'template_rights' => 'Jungle Life. Todos los derechos reservados.',

    //Password Reset Mail
    'Hello' => 'Hola :object',

    //Welcome User Mail
    'welcome_subject' => 'Bienvenido a ',
    'welcome_mgs1' => 'Estás recibiendo este email ya que te incluimos en la familia de Jungle Life. ',
    'welcome_btn' => 'Crear contraseña ',
    'welcome_thanks' => 'Gracias por utilizar nuestra aplicación. ',

    //Approval Mail
    'approval_subject' => 'Se a creado una solicitud  de cambio en ',
    'approval_mgs1' => 'Estás recibiendo porque se ha solicitado realizar un cambio del maximo al ',
    'approval_btn' => 'Ir a la solicitud ',

    //Thanks Mail
    'thanks_mail_mg1' => 'Gracias por utilizar nuestros servicios',

    //Invoice
    'invoice_thanks' => 'Gracias por visitarnos',
    'invoice_tittle' => 'Comprobante de Compra',
    'invoice_btn_show' => 'Ver Factura',
    'invoice_btn_send' => 'Enviar Factura',
    'invoice_message_send' => 'Se ha incluido la factura en la cola de Envio',

    //Welcome to View
    'welcome_view_message' => 'Para iniciar crea una contraseña ',
    'welcome_view_success' => '¡Se ha creado el usuario correctamente!',

    //Template Interface
    'profile' => 'Mi Perfil',
    'profile2' => 'Perfil',
    'passwords' => 'Contraseña',
    'new_passwords' => 'Nueva contraseña',
    'old_passwords' => 'Contraseña actual',
    'confirm_passwords' => 'Confirmar contraseña',
    'passwords_error' => 'La contraseña no coincide',
    'image_error' => 'Debe de adjuntar una imagen',
    'avatars' => 'Avatar',
    'settings' => 'Configuración',
    'calendar' => 'Calendario',
    'calendar_show' => 'Ver el calendario',
    'logout' => 'Salir',

    //Sidebar
    'info_tours' => "Información para tours",
    'tour_config_tittle' => 'Configuración de tours',
    'tour_tittle' => 'Tours',
    'config_tour' => 'Opciones de tour',
    'config' => 'Configuración',
    'log_tittle' => 'Log de errores',
    'reports' => 'Reportes',

    //Home
    'welcome_home' => 'Bienvenido',
    'welcome_invoice' => 'Facturas',
    'welcome_web' => 'Ventas Web',
    'data_monthly' => 'Datos Mensuales',
    'data_daily' => 'Datos Diarios',
    'data_all' => 'Datos Totales',


    //Calendar
    'calendar_error' => 'Hubo un error al encontrar los eventos',
    'close' => 'Cerrar',
    'goTour' => 'Ir a ver el tour',

    //Crud Interface
    'home' => 'Inicio',
    'create' => 'Crear',
    'crud_show' => 'Ver',
    'crud_edit' => 'Editar',
    'approval_edit' => 'Verificar',
    'crud_delete' => 'Eliminar',
    'crud_action' => 'Acciones',
    'show_tittle' => 'Ver un :object',
    'edit_tittle' => 'Editar un :object',
    'create_tittle' => 'Crear un :object',
    'edit_btn' => 'Actualizar',
    'delete_title' => '¿Esta seguro?',
    'delete_text' => 'Que desea eliminar el ',
    'delete_confirmButtonText' => '¡Confirmar!',
    'delete_cancelButtonText' => 'Cancelar',
    'delete_success_tittle' => '¡Eliminado!',
    'delete_success' => '¡Se ha eliminado con exito!',
    'delete_error' => 'Error',
    'delete_error_text' => 'Se produjo un error al intentar eliminarlo',
    'go_index' => 'Volver a la lista',
    'go_exchange' => 'Ir a los Tipos de Cambios',
    'msg_contact_admin' => 'Favor Contactar con un administrador',


    // Crud Entities
    'tour' => "Tours",
    'tour_singular' => "Tour",
    'tours_active' => "Tours activos",
    'tours_history' => "Historial de tours",
    'tours_book' => "Reservar tour",
    'tours_of' => " Tour de ",
    'invoice' => "Factura",
    'invoice_state' => "Estado de la factura",
    'invoice_type' => "Tipo de factura",
    'booking' => "Reservas",
    'type_guides' => "Tipos de guias",
    'type_guides_singular' => "Tipo de guia",
    'tour_states' => "Estados de tours",
    'tour_states_singular' => "Estado de tour",
    'tour_type' => "Tipos de tours",
    'tour_type_singular' => "Tipo de tour",
    'type_client' => "Tipos de clientes",
    'type_client_singular' => "Tipo de cliente",
    'guide' => "Guias",
    'guide_singular' => "Guia",
    'customer' => "Clientes",
    'customer_single' => "Cliente",
    'user' => "Usuarios",
    'user_singular' => "Usuario",
    "timetables" => 'Horarios',
    "timetables_singular" => 'Horario',
    "create_by" => 'Creado por',
    "tittle_view_guide" => 'Ver los guias del tour',
    "tittle_view_clients" => 'Ver los clientes del tour',
    "tittle_config" => 'Configuraciones del sitio',
    'products' => 'Productos',
    'products_singular' => 'Producto',
    'product_type' => 'Tipos de productos',
    'product_type_singular' => 'Tipo de producto',
    'payment_type' => 'Tipo de pago',
    'exchange_rate_force'=> 'Buscar tipo de Cambio',
    'increase_request'=> 'Solicitud de Aumento',
    'requests_for_increases'=> 'Solicitudes',
    'requests_for_increases_singular'=> 'Solicitud',



    //Crud Attributes
    'id'=> 'Id',
    'name'=> 'Nombre',
    'lastname'=> 'Apellido',
    'price'=> 'Precio',
    'email'=> 'Email',
    'telephone'=> 'Teléfono',
    'rol'=> 'Rol',
    'money_type'=> 'Moneda',
    'star'=> 'Inicio',
    'end'=> 'Final',
    'auto'=> 'Creacion automática',
    'auto_system'=> 'Creado automaticamente por el sistema',
    'date'=> 'Fecha',
    'status'=> 'Estado',
    'schedule'=> 'Horario',
    'information'=> 'Información',
    'description' => 'Descripción',
    'comments' => 'Comentarios',
    'from'=> 'Desde ',
    'to'=> ' Hasta ',
    'type'=> ' Tipo ',
    'state'=> ' Estado ',
    'status_values' => [
        'true' => 'Activo',
        'false' => 'Inactivo',
    ],
    'status_values2' => [
        'true' => 'Si',
        'false' => 'No',
    ],
    'quantity'=> 'Cantidad de ',
    'quantity2'=> 'Cantidad ',
    'quantity_royalties'=> 'Regalias',
    'creat_by'=> 'Creado por  ',
    'select_date'=> 'Selecciona la fecha del tour',
    'select_type_guide'=> 'Seleccione un tipo guia',
    'select_client_type'=> 'Seleccione un tipo cliente',
    'select_role'=> 'Seleccione un rol',
    'select_money_type'=> 'Seleccione un tipo de moneda',
    'select_payment_type'=> 'Seleccione un tipo de pago',
    'select_payment_type_error'=> 'Debe de seleccionar un tipo de pago',
    'select_star'=> 'Seleccione un hora de inicio',
    'select_end'=> 'Seleccione un hora de fin',
    'select_schedule'=> 'Seleccione un horario',
    'select_tour_type'=> 'Seleccione un tipo de Tour',
    'select_guide' => 'Seleccione un guia',
    'product_type_select' => 'Seleccione un tipo de producto',
    'auto_message'=> 'Este campo permite automatizar la creacion de tour con este horarios si se activa',
    'add_tour_guide_tittle' => 'Incluir un guia en el tour',
    'add_tour' => 'Incluir en el tour',
    'add_tour_client_tittle' => 'Incluir un cliente en el tour',
    'search_client' => 'Buscar un cliente',
    'search_client_error1' => 'Debe de seleccionar un cliente',
    'search_product' => 'Selección de producto',
    'add_product' => 'Incluir producto',
    'not_products' => 'No posee productos seleccionados',
    'available_space' => 'Espacios disponibles: ',
    'used_space' => 'Espacios usados',
    'not_space' => 'No hay suficiente espacio en el tour para incluir',

    //booking
    'tittle_tour' => 'Selección de tour',
    'select_tour' => 'Seleccione un tour',
    'select_client' => 'Seleccione un cliente',
    'end_booking' => 'Finalizar reserva',
    'no_tour' => 'No se encontraron disponibles tour para la fecha: ',
    'send_invoice' => 'Requiere factura',
    'send_electronic_invoice' => 'Requiere factura electrónica',
    'required_credit' => 'Requiere crédito',
    'total' => 'Total',
    'booking_error' => 'Hubo un error al intentar crear la reserva del Tour',
    'final_step' => 'Finalizar compra',
    'thanks' => 'Muchas gracias por su compra',
    'present' => 'Esta presente',
    'present_1' => 'Presente',
    'no_present' => 'No presente',
    'no_guide' => 'Guia no asignado',
    'success_is_present' => 'Se ha modificado con éxito el estado el del cliente',
    'success_set_guide_to_costumer' => 'Se ha modificado con éxito el guia del cliente',
    'fee' => 'Comisiones',
    'fee_1' => 'De 1 a 2',
    'fee_2' => 'De 3 a 4',
    'fee_3' => 'De 5 a 7',
    'fee_4' => 'De 7 en adelante',
    'exchange' => 'Tipo de cambio',
    'exchange_buy' => 'Compra',
    'exchange_sell' => 'Venta',

    //Approval
    'btn_approved' => 'Aprobar',
    'btn_rejected' => 'Rechazar',
    'btn_request' => 'Solicitar Aprobación',
    'approve_user' => 'Solicitante',
    'approve_date' => 'Fecha de Solicitud',
    'approve_reviewer' => 'Aprobador',
    'approve_guide_qty' => 'Cantidad de Clientes por Guia',
    'approve_booking' => 'Reservas Actuales',
    'approve_space' => 'Espacio actual del Tour',
    'approve_new' => 'Nuevo Valor de Cantidad de Clientes por Guia ',
    'approve_msg1' => 'Se aprueba el aumento automáticamente ',
    'approve_msg2' => 'Se crea la solicitud de aumento',
    'approve_msg3' => 'Se procesa la solicitud',
    'approve_mail_title' => 'Muchas Gracias por Visitarnos',


    //Invoice
    'invoice_subject' => 'Gracias por su compra',
    'detail' => 'Detalle',

    //Config
    'config_basic' => 'Basica',
    'config_email' => 'Correos',
    'config_api' => 'API',
    'config_error' => 'Al intentar actualizar las configuraciones',
    'config_5' => 'Activo envia',
    'config_tittle_mail_thanks' => 'Correos de Agradecimientos',

    //Reports
    'profits' => 'Ganancias',
    'guides_cost' => 'Costos de Guias',



    //Environment
    'developer' => 'Desarrollador',
    'environment' => 'Entorno',
    'local' => 'Local',
    'develop' => 'Development',
    'stage' => 'Stage',
    'production' => 'Production',
];
