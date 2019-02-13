// SCRIPT FOR TEXT EDITOR

var textarea = document.body.appendChild( document.createElement( 'textarea' ) );
CKEDITOR.replace( textarea ,{
    language: 'da',
    height: '100',
    uiColor: '#9AB8F3',
    toolbarCanCollapse: 'true'
});
