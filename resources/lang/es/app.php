<?php

return [
    //Controllers message
    'error_create'=>  'Hubo un error al crear el :object',
    'error_update'=>  'Hubo un error al actualizar el :object',
    'error_delete'=>  'Hubo un error Interno',
    'success_create '=> 'Se ha creado con exito el :object',
    'success_update '=> 'Se ha actualizado con exito el :object',
    'success'=> 'Exitoso',

    //login
    'login_msg1' => 'Bienvenido a Jungle Life 👋',
    'login_msg2' => 'Inicie sesión en su cuenta y comience la aventura',
    'login_mail' => 'Correo',
    'login_pass' => 'Contraseña',
    'login_forgot' => 'Olvido la Contraseña?',
    'login_remember' => 'Recordarme',
    'login_btn' => 'Ingresar',

    //login Fail
    'not_active' => 'Usuario no se encuentra Activo',
    'throttled' => 'Demasiados intentos de inicio de sesión. Por favor, inténtelo de nuevo en :time  segundos ',
    'user_error' => 'Nombre de usuario o contraseña incorrectos',

    //Reset Password
    'reset_msg1' => 'Restablecer Contraseña',
    'reset_go_Login' => 'Volver al Inicio de Seccion',
    'reset_btn' => 'Solicitar Restablecer Contraseña',
    'mail.error' => 'El Correo es incorrecto',
    'send.email' => 'Se ha enviado el correo de restablecer la contraseña',
    'confirm.reset.btn' => 'Restablecer',
    'login_pass.confirm' => 'Confirmar Contraseña',

    //Password Reset Admin
    'admin_reset_text' => 'Que desea resetear la contraseña de ',
    'admin_success_tittle' => 'Ok',
    'admin_success_message' => 'Se ha enviado el correo para restablecer la contraseña',
    'admin_error_message' => 'Hubo un error al intentar Reiniciar la contrasena',

    //Password Reset Mail
    'Hello' => 'Hola :object',

    //Welcome User Mail
    'welcome_subject' => 'Bienvemido a ',
    'welcome_mgs1' => 'Estás recibiendo este email ya que te incluimos en la familia de Jungle Life. ',
    'welcome_btn' => 'Crear Contraseña ',
    'welcome_thanks' => 'Gracias por utilizar nuestra aplicación. ',

    //Welcome View
    'welcome_view_message' => 'Para iniciar crea una contraseña ',
    'welcome_view_success' => 'Se ha creado el usuario Correctamente',

    //Template Interface
    'profile' => 'Mi Perfil',
    'profile2' => 'Perfil',
    'passwords' => 'Contraseña',
    'new_passwords' => 'Nueva Contraseña',
    'old_passwords' => 'Contraseña Actual',
    'confirm_passwords' => 'Confirmar Contraseña',
    'passwords_error' => 'La Contraseña no Coincide',
    'image_error' => 'Debe de Adjuntar una imagen',
    'avatars' => 'Avatar',
    'settings' => 'Configuración',
    'calendar' => 'Calendario',
    'calendar_show' => 'Ver el Calendario',
    'logout' => 'Salir',

    //Sidebar
    'info_tours' => "Informacion para Toures",
    'tour_config_tittle' => 'Configuración de Tours',
    'tour_tittle' => 'Tours',
    'config' => 'Configuracion',

    //Calendar
    'calendar_error' => 'Hubo un error al encontrar los Eventos',
    'close' => 'Cerrar',
    'goTour' => 'Ir a ver el Tour',

    //Crud Interface
    'home' => 'Inicio',
    'create' => 'Crear',
    'crud_show' => 'Ver',
    'crud_edit' => 'Editar',
    'crud_delete' => 'Eliminar',
    'crud_action' => 'Acciones',
    'show_tittle' => 'Ver un :object',
    'edit_tittle' => 'Editar un :object',
    'create_tittle' => 'Crear un :object',
    'edit_btn' => 'Actualizar',
    'delete_title' => 'Esta seguro?',
    'delete_text' => 'Que desea eliminar el :object',
    'delete_confirmButtonText' => 'Confirmar!',
    'delete_cancelButtonText' => 'Cancelar',
    'delete_success_tittle' => 'Eliminado!',
    'delete_success' => 'Se ha eliminado con exito!',
    'delete_error' => 'Error',
    'delete_error_text' => 'Se produjo un error al intentar eliminarlo',
    'go_index' => 'Volver a la Lista',


    // Crud Entities
    'tour' => "Tours",
    'tour_singular' => "Tour",
    'type_guides' => "Tipos de Guias",
    'type_guides_singular' => "Tipo de Guia",
    'tour_states' => "Estados de Tours",
    'tour_states_singular' => "Estado de Tour",
    'tour_type' => "Tipos de Tours",
    'tour_type_singular' => "Tipo de Tour",
    'type_client' => "Tipos de Clientes",
    'type_client_singular' => "Tipo de Cliente",
    'guide' => "Guias",
    'guide_singular' => "Guia",
    'customer' => "Clientes",
    'customer_single' => "Cliente",
    'user' => "Usuarios",
    'user_singular' => "Usuario",
    "timetables" => 'Horarios',
    "timetables_singular" => 'Horario',

    //Crud Attributes
    'id'=> 'Id',
    'name'=> 'Nombre',
    'lastname'=> 'Apellido',
    'price'=> 'Precio',
    'email'=> 'Email',
    'telephone'=> 'Telefono',
    'rol'=> 'Rol',
    'money_type'=> 'Moneda',
    'star'=> 'Inicio',
    'end'=> 'Final',
    'auto'=> 'Creacion Automatica',
    'date'=> 'Fecha',
    'status'=> 'Estado',
    'schedule'=> 'Horario',
    'information'=> 'Informacion',
    'from'=> 'Desde ',
    'to'=> ' Hasta ',
    'status_values' => [
        'true' => 'Activo',
        'false' => 'Inactivo',
    ],
    'status_values2' => [
        'true' => 'Si',
        'false' => 'No',
    ],
    'quantity'=> 'Cantidad de ',
    'creat_by'=> 'Creado por  ',
    'select_date'=> 'Selecciona la Fecha del Tour',
    'select_type_guide'=> 'Seleccione un tipo Guia',
    'select_client_type'=> 'Seleccione un tipo Cliente',
    'select_role'=> 'Seleccione un Rol',
    'select_money_type'=> 'Seleccione un Tipo de Monda',
    'select_star'=> 'Seleccione un Hora de Inicio',
    'select_end'=> 'Seleccione un Hora de Fin',
    'select_schedule'=> 'Seleccione un Horario',
    'auto_message'=> 'Este Campo permite Automatizar la creacion de Tour con este Horarios si se activa',
];
