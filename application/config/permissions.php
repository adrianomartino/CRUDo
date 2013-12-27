[admin]
can_read='ALL'
can_create='ALL'
can_edit='ALL'
can_publish='ALL'
can_destroy='ALL'


[developer]
can_read='ALL'
can_create='ALL'
can_edit='ALL'
can_publish='ALL'
can_destroy='ALL'
                

[editor]
can_read='HIS_ITEMS'
can_create='HIS_GROUPS'
can_edit='HIS_ITEMS'
can_publish='NONE'
can_destroy='HIS_ITEMS'                
                

[supervisor]
can_read='HIS_GROUPS'
can_create='HIS_GROUPS'
can_edit='HIS_GROUPS'
can_publish='HIS_GROUPS'
can_destroy='HIS_GROUPS'


[public]
can_read='PUBLIC_ITEMS'
can_create='USER,COMMENTI'
can_edit='NONE'
can_publish='NONE'
can_destroy='NONE'


[registered]
can_read='HIS_ITEMS'
can_create='USER,COMMENTI'
can_edit='HIS_ITEMS'
can_publish='NONE'
can_destroy='HIS_ITEMS'