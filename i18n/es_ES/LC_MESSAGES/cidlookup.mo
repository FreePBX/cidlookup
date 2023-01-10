��    T      �  q   \         [   !  \   }  U   �  )   0  @   Z  �   �  �  L	     �
     �
     �
     �
  r   �
  
   q     |  	   �     �     �     �     �     �     �     �               <     M     V     d     �     �     �       $   
  .   /  
   ^     i     o     v     {     �     �  	   �  3   �  
   �       9     
   L     W     f     u     |          �     �      �     �  	   �     �  &   �                @   $     e     k  �   �             /   ;     k     r     �  :   �     �  P   �     $  w   )     �  &   �     �  �  �  p   �  o   �  �  h  l      m   �  i   �  )   e  _   �  �   �  �  �     =     I     R     k  �   q            	   &     0  &   A  &   h     �     �     �     �  &   �  -        6     R     `  �   u                    ,  -   2  ?   `     �     �     �  	   �     �  %   �              F         ]      m   V   ~      �      �      �      !     !     !  +    !     L!  !   U!      w!  	   �!     �!  5   �!     �!  >  �!     *#  P   1#  	   �#  z  �#  �   %     �%  +   �%  5   �%     #&     *&     A&  X   P&     �&  M   �&     �&  y   '     }'  ;   �'     �'  �  �'  l   �)  x   *     2       4       Q       J   G   B           ,       6   8      A   -   9           *      3   /          $          
   O   P         S             5   =   R       !   T         C   H         ?       M   E      L         I           <   &   :                 '       7   N   0             #       %   .       	              ;   "       F      )   >           @         +       (             1             K      D         It executes an HTTP GET passing the caller number as argument to retrieve the correct name  It executes an HTTPS GET passing the caller number as argument to retrieve the correct name  Use DNS to lookup caller names, it uses ENUM lookup zones as configured in enum.conf  Use OpenCNAM [https://www.opencnam.com/]  use astdb as lookup source, use phonebook module to populate it <p>If you need to create an OpenCNAM account, you can visit their website: <a href="https://www.opencnam.com/register" target="_blank">https://www.opencnam.com/register</a></p> A Lookup Source let you specify a source for resolving numeric CallerIDs of incoming calls, you can then link an Inbound route to a specific CID source. This way you will have more detailed CDR reports with information taken directly from your CRM. You can also install the phonebook module to have a small number <-> name association. Pay attention, name lookup may slow down your PBX Account SID: Actions Add CIDLookup Source Admin Allows CallerID Lookup of incoming calls against different sources (OpenCNAM, MySQL, HTTP, ENUM, Phonebook Module) Auth Token CID Lookup Source CIDLookup Cache Results Caller ID Format CallerID Lookup CallerID Lookup Sources Character Set Company Contact Manager Contact Manager Group(s) Contact Manager Not Installed Contact Manager: Database Database Name Decide whether or not cache the results to astDB; it will overwrite present values. It does not affect Internal source behavior Delete Description Display Name ENUM: Enter a description for this source. Filter results to these contact manager groups First Last HTTP: HTTPS: Host Host name or IP address How to format the returned data Internal Internal: It queries a MySQL database to retrieve caller name Last First List Sources MySQL Character Set. Leave blank for MySQL default latin1 MySQL Host MySQL Password MySQL Username MySQL: No None Not yet implemented OpenCNAM OpenCNAM Requires Authentication OpenCNAM Throttle Reached! OpenCNAM: Password Password to use in HTTP authentication Path Path of the file to GET<br/>e.g.: /cidlookup.php<br>Special token '[NUMBER]' will be replaced with caller number<br/>e.g.: /cidlookup/[NUMBER]/<br/>'[NAME]' will be replaced with existing caller id name<br/>'[LANGUAGE]' will be replaced with channel language Port Port HTTP(s) server is listening at (default http 80, https 443) Query Query string, special token '[NUMBER]' will be replaced with caller number<br/>e.g.: number=[NUMBER]&source=crm<br/>'[NAME]' will be replaced with existing caller id name<br/>'[LANGUAGE]' will be replaced with channel language<br/>'[UNIQUEID]' will be replaced with unique Asterisk callID Query, special token '[NUMBER]' will be replaced with caller number<br/>e.g.: SELECT name FROM phonebook WHERE number LIKE '%[NUMBER]%' Reset Searches a contact manager group Select the source type, you can choose between: Source Source Description Source type Sources can be added in Caller Name Lookup Sources section Submit There are %s DIDs using this source that will no longer have lookups if deleted. Type Unauthenticated calls to the OpenCNAM API will soon fail. You will need an OpenCNAM account to continue using their API Username Username to use in HTTP authentication Yes You have gone past the free OpenCNAM usage limits.<br/><br/>To continue getting caller ID name information, you need to create an OpenCNAM Professional Account.<br/><br/>You can create an OpenCNAM account at: <a href="https://www.opencnam.com/register">https://www.opencnam.com/register</a>.<br/><br/>Once you have created an account, visit the CallerID Lookup Sources menu and enter your OpenCNAM Professional Tier credentials.<br/> Your OpenCNAM Account SID. This can be found on your OpenCNAM dashboard page: https://www.opencnam.com/dashboard Your OpenCNAM Auth Token. This can be found on your OpenCNAM dashboard page: https://www.opencnam.com/dashboard Project-Id-Version: Spanish (FreePBX)
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2023-01-10 12:04+0000
PO-Revision-Date: YEAR-MO-DA HO:MI+ZONE
Last-Translator: FULL NAME <EMAIL@ADDRESS>
Language-Team: Spanish <http://weblate.freepbx.org/projects/freepbx/cidlookup/es/>
Language: es
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=2; plural=n != 1;
X-Generator: Weblate 3.0.1
  Esto ejecuta un HTTP GET  pasando el numero quien llama como un argumento para encontrar el nombre correcto  Esto ejecuta un HTTPS GET  pasando el numero quien llama como un argumento para encontrar el nombre correcto  Use DNS para buscar nombre de quien llama,  usa busqueda de zonas ENUM tal como configurado en enum.conf  Usa OpenCNAM [https://www.opencnam.com/]  use astdb como fuente en la búsqueda, use modulo listin telefónico (phonebook) para poblarlo <p> Si necesitase crear una cuenta OpenCNAM, se puede visitar su página web: <a href="https://www.opencnam.com/register" target="_blank">https://www.opencnam.com/register</a></p> Una fuente de búsqueda le permite utilizar una fuente para identificar el número de la persona que llama en las llamadas entrantes. De esta forma tendrá informes más detallados con la información extraida de su CRM. Puede instalar también el módulo "Listín telefónico" para tener una relación número <-> nombre. Tenga cuidado, ya que la búsqueda de nombres puede penalizar el rendimiento de su PBX Cuenta SID: Acciones Agregar Fuente CIDLookup Admin Permite búsqueda CallerID de las llamadas entrantes contra de diferentes fuentes (OpenCNAM, MySQL, HTTP, ENUM, Módulo de la guía telefónica) Clave Autorizacion Búsqueda de CID CIDLookup Resultados Cache Formato de Identificación de Llamadas Búsqueda de identificador de llamante Búsqueda de llamantes Conjunto de Caracterees Empresa Administrador de Contactos Grupo(s) de Administrador de Contactos Administrador de Contactos no está instalado Administrador de Contactos: Base de Datos Nombre Base de Datos Decide si se ponen los resultados de astDB en cache o no; sobrescribira los valores actuales. No afecta el comportamiento de la fuente interna Borrar Descripción Nombre para mostrar ENUM: Introduzca una descripción para este origen. Filtrar resultados a estos grupos de administrador de contactos Primer Último HTTP: HTTPS: Anfitrion Nombre del servidor o IP Cómo formatear a los datos devueltos Interno Interno: Solicita a base de datos MySQL el recuperar el nombre de quien llamada Último Primero Lista de Fuentes MySQL. Conjunto de Caracteres. Dejar en Blanco para que MySQL asuma por defecto latin1 Servidor MySQL Contraseña MySQL Nombre de usuario MySQL MySQL: No Ninguno Este método no se ha implementado todavía OpenCNAM OpenCNAM Requiere Autenticanción Aceleración OpenCNAM Alcanzada! OpenCNAM: Contraseña Contraseña que se usará en la autentificación HTTP Camino Camino del archivo para obtener <br/> por ejemplo: /cidlookup.php <br> símbolo especial '[NUMBER]' será reemplazado por el número de quien llama<br/> por ejemplo: / cidlookup / [NUMBER]/<br/> '[NAME]' será reemplazado con el nombre conocido de la persona <br/>'[LANGUAGE]'será reemplazado con el lenguaje de canal Puerto Puerto en el que server HTTP(s) esta escuchando (por defecto http:80, https:443) Solicitud Cadena de consulta, tóken especial '[NUMBER]' se reemplazará con el número de la persona que llama<br/> por ejemplo: número=[NUMBER]&source=crm<br/>'[NAME]' será reemplazado con el nombre de identificación de llamadas existente<br/>'[LANGUAGE]' será reemplazado con el idioma del canal<br/>'[UNIQUEID]' será reemplazado con el identificador de llamada únido de Asterisk Cadena de la consulta, el campo "[NUMBER]" sera sustituido con el número de la persona que llama.<br/>Por ejemplo, SELECT name FROM phonebook WHERE number LIKE '%[NUMBER]%' Restablecer Busca un grupo de administrador de contacto Escoger el tipo de fuente, usted puede escoger entre: Fuente Descripción de Fuente Tipo de Fuente Se pueden añadir fuentes en la sección de Fuentes de búsqueda de nombres de llamantes Enviar Hay %s DIDs usando esta fuente que no tendrá mas búsquedas si es eliminada. Tipo Llamadas no autenticadas a la API OpenCNAM pronto fallarán. Necesitará una cuenta OpenCNAM para continuar usando su API Usuario Nombre de usuario que se usará en la autentificación HTTP Si Va a sobrepasar los niveles maximos de uso gratis de OpenCNAM.<br/><br/>Para continuar recibiendo informacion del nombre del caller ID, usted necesita una cuenta profesional de OpenCNAM.<br/><br/>Usted puede crear una cuenta de OpenCNAM ent: <a href="https://www.opencnam.com/register">https://www.opencnam.com/register</a>.<br/><br/>Una vez haya creado una cuenta, visite el menu de Fuentes de Busqueda de callerID e introduzca sus credenciales de cuenta de OpenCNAM.<br/> Cuenta SID OpenCNAM. Esta puede ser encontrada en el tablero OpenCNAM en: https://www.opencnam.com/dashboard Clave Autorización OpenCNAM. Esto peude ser encontrado en el tablero de OpenCNAM en: https://www.opencnam.com/dashboard 