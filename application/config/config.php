; This is the ini file


[site_defaults]
site_name='CRUDo - Rapid Development Platform, surprisingly based on PHP!'	
site_payoff='Import any database structure in minutes. Create Views. Enjoy your website with lots of standard features'	
site_description='Import any database structure in minutes. Create Views. Enjoy your website with lots of standard features'
;site_facebook_users='your_facebook_user_name_here'


[contacts]
postmaster="postmaster@"SERVER_HTTP_HOST
info_email="info@"SERVER_HTTP_HOST
support_email="help@"SERVER_HTTP_HOST
webmaster="Adriano Martino"
webmaster_contact="adriano@martinobranding.com"
;webmaster_site=''


[registry]
admin_name='Italian label, Inc'
admin_street_address="22nd N 3rd st"
admin_postal_code=19106
admin_city=Philadelphia
admin_state=PA
admin_country='United States'
admin_phone='+1 786-376-7156'
;admin_fax=
admin_email="hello@martinobranding.com"
;admin_company_number=

[file_handling]
UPLOAD_FOLDER=DOC_ROOT'public/files/'
SHARED=ROOT'public/files/'
UPLOAD_IMAGES_SIZES="70x70 300x300 530x400 1200x1200"
ALLOWED_FILE_TYPES="doc rtf xls ppt pps pdf tif tiff jpg gif png bmp mp4 zip"
ALLOWED_IMAGE_TYPES="jpg jpeg gif png"
IMAGES_MAX_DIMENSIONS="120 350 530 1000"
MAX_FILE_SIZE=52428800


[default_urls]
admin_root=ROOT'admin/'


[form_settings]
;define form action ( Like PHP_SELF but compatible with URL rewriting )
FORM_ACTION="http://"SERVER_HTTP_HOST""SERVER_REQUEST_URI

[international]
DEFAULT_LANGUAGE=en

;You can change this anytime
;to change the order or the appereance of the languages

LANGUAGES='en es it de fr ru zh'


[settings]
SESSION_CACHE_EXPIRE=120


[db_settings]
Local Settings:
DB_HOST=localhost
DB_USER=CRUDo
DB_PASSWORD=CrudoSandB0x
DB=CRUDo



;
; Live DB settings:
; DB_HOST=
; DB_USER=
; DB_PASSWORD=
; DB=
;



[db_tables]
users_table=UTENTI

;tab_prefix='' ;if your site tables have a common prefix
;defining relationships tables
rel_tables='COMMENTI,_drafts,_translations'


[include_paths]
;
;
; Add here every path you want to be included
;
;
models_dir=APPLICATION'models/'
item_models_dir=APPLICATION'models/items/'
controllers_dir=APPLICATION'controllers/'
abstract_controllers_dir=APPLICATION'controllers/abstracts/'
items_controllers_dir=APPLICATION'controllers/pages/'
library_dir=APPLICATION'library/'
external_library_dir=APPLICATION'library/external/'
views_dir=APPLICATION'views/'
admin_views_dir=APPLICATION'views/admin/'
public_views_dir=APPLICATION'views/public/'
views_helpers_dir=APPLICATION'views/view_helpers/'
configs_dir=APPLICATION'config/'


[other_inclusions]
css_dir=ROOT'public/css/'
rss_dir=ROOT'public/rss/'
scripts_dir=ROOT'public/scripts/'
script_calls=APPLICATION'views/structure/_script_calls/'
ajax_pages=DOC_ROOT'public/ajax_pages/'




[options]
;
; Defines the format of your url
; You can specify 'short', 'medium','full_path'
; short will be something like: domain.com/item_name
; medium: domain.com/main_topic/item_name
; full_path: domain.com/main_topic/sub_cat/sub_cat2/item_name
;

url_format='medium'


[not_to_save_as_constants]
; by default every var in this
; config file is defined as a constant
; here you can list the groups
; of information that you don't want
; to define as constants but only use
; as subarray

not_to_save_as_constants=true
allowed_get_vars=true


[allowed_get_vars]
; For added security we only accept get vars that we have defined and discard the others

logout=''
site_lang=lang
translate_from=uid
user_email=email
user_password=''



[apy_keys]
facebook_app_id=''