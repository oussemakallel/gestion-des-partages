/* en ms */  
const TABLE_REFRESH_RATE = 2500 , NOTIFICATIONS_REFRESH_RATE = 2500
    var id;
    var formpass = true;
    var id_dem;
    var pname;
    var quota;
    var type_dem;
    var selectedserver;
    var selecteddisc;
    var xuser;
    var max_fields =7;
    var table14;
$(document).ready(function() {
    //disable enter press submit
    $(window).keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
    
  
    
    var $table1 = jQuery('#adminsharetable');
    var $table2 = jQuery('#adminrequesttable');
    var $table3 = jQuery('#userrequesttable');
    var $table4 = jQuery('#collaedittable');
    var $table5 = jQuery('#collabshowtable');
    var $table6 = jQuery('#collabadmintable');
    var $table7 = jQuery('#collabadminmodiftable');
    var $table8 = jQuery('#usersharetable');
    var $table9 = jQuery('#sharecollabshowtable');
    var $table10 = jQuery('#collabusermodiftable');
    var $table11 = jQuery('#taskstable');
    var $table12 = jQuery('#serverstable');
    var $table13 = jQuery('#disctable');
    var $table14 = jQuery('#techsharetable');




    var table1 = $table1.DataTable({ 
            columnDefs: [
      { className: 'never', targets: [10,3,4] }
    ],
        responsive:true,
        language: {
            "sProcessing": "Traitement en cours ...",
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "Aucun résultat trouvé",
            "sEmptyTable": "Aucune donnée disponible",
            "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
            "sInfoEmpty": "Aucune ligne affichée",
            "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
            "sInfoPostFix": "",
            
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Chargement...",
            "sSearch":         "",
             //"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "oPaginate": {
                "sFirst": "Premier",
                "sLast": "Dernier",
                "sNext": "Suivant",
                "sPrevious": "Précédent"
            },
            "oAria": {
                "sSortAscending": ": Trier par ordre croissant",
                "sSortDescending": ": Trier par ordre décroissant"
            }
        },

        ajax : 'Controllers/partages.php',
        destroy: true,
        bStateSave: true,
       
    });
   table1.column( 3 ).visible( false );
    table1.column( 4 ).visible( false );
    table1.column( 10 ).visible( false );
    var table2 = $table2.DataTable({ 
                 columnDefs: [
      { className: 'never',
       "visible": false,
        "searchable": false,
       targets: 1 }
    ],
        responsive:true,
        destroy: true,
        ajax: 'Controllers/demandes.php?type=c',
        bStateSave: true,
       
        "language": {
            "sProcessing": "Traitement en cours ...",
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "Aucun résultat trouvé",
            "sEmptyTable": "Aucune donnée disponible",
            "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
            "sInfoEmpty": "Aucune ligne affichée",
            "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
            "sInfoPostFix": "",
            "sUrl": "",
            "sSearch":         "",
            //"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfoThousands": ",",
            "sLoadingRecords": "Chargement...",
            "oPaginate": {
                "sFirst": "Premier",
                "sLast": "Dernier",
                "sNext": "Suivant",
                "sPrevious": "Précédent"
            },
            "oAria": {
                "sSortAscending": ": Trier par ordre croissant",
                "sSortDescending": ": Trier par ordre décroissant"
            }
        },
    });
    table2.column( 3 ).visible( false );
    var table3 = $('#userrequesttable').DataTable({ 
        responsive:true,
    columnDefs: [{ className: 'never',
                  "visible": false,
        "searchable": false,
        targets: [0,1,2,4,5 ]}
    ],

        language: {
            "sProcessing": "Traitement en cours ...",
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "Aucun résultat trouvé",
            "sEmptyTable": "Aucune donnée disponible",
            "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
            "sInfoEmpty": "Aucune ligne affichée",
            "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
            "sInfoPostFix": "",
            
            "sUrl": "",
            "sSearch":         "",
            //"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfoThousands": ",",
            "sLoadingRecords": "Chargement...",
            "oPaginate": {
                "sFirst": "Premier",
                "sLast": "Dernier",
                "sNext": "Suivant",
                "sPrevious": "Précédent"
            },
            "oAria": {
                "sSortAscending": ": Trier par ordre croissant",
                "sSortDescending": ": Trier par ordre décroissant"
            }
        },

        ajax: 'Controllers/demandes.php?type=c',
        destroy: true,
        "bStateSave": true,
       
    });
    table3.column( 0 ).visible( false );
    table3.column( 1 ).visible( false );
    table3.column( 2 ).visible( false );
    table3.column( 3 ).visible( false );
    table3.column( 4 ).visible( false );
    table3.column( 5 ).visible( false );
    var table4 = $table4.DataTable({ responsive:true,
    
        language: {
            "sProcessing": "Traitement en cours ...",
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "Aucun résultat trouvé",
            "sEmptyTable": "Aucune donnée disponible",
            "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
            "sInfoEmpty": "Aucune ligne affichée",
            "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
            "sInfoPostFix": "",
            
            "sUrl": "",
            "sSearch":         "",
            //"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfoThousands": ",",
            "sLoadingRecords": "Chargement...",
            "oPaginate": {
                "sFirst": "Premier",
                "sLast": "Dernier",
                "sNext": "Suivant",
                "sPrevious": "Précédent"
            },
            "oAria": {
                "sSortAscending": ": Trier par ordre croissant",
                "sSortDescending": ": Trier par ordre décroissant"
            }
        },

        destroy: true,
        bLengthChange: false,
        bFilter: false,
        bPaginate: true,
        pagingType: "simple",
        iDisplayLength: 5,
        bStateSave: true,
       
    });
    var table5 = $table5.DataTable({ responsive:true,
        
        language: {
            "sProcessing": "Traitement en cours ...",
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "Aucun résultat trouvé",
            "sEmptyTable": "Aucune donnée disponible",
            "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
            "sInfoEmpty": "Aucune ligne affichée",
            "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
            "sInfoPostFix": "",
            
            "sUrl": "",
            "sSearch":         "",
            //"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfoThousands": ",",
            "sLoadingRecords": "Chargement...",
            "oPaginate": {
                "sFirst": "Premier",
                "sLast": "Dernier",
                "sNext": "Suivant",
                "sPrevious": "Précédent"
            },
            "oAria": {
                "sSortAscending": ": Trier par ordre croissant",
                "sSortDescending": ": Trier par ordre décroissant"
            }
        },
        destroy: true,
        bLengthChange: false,
        bFilter: false,
        bPaginate: true,
        pagingType: "simple",
        iDisplayLength: 5,
        bStateSave: true,
        
    });   
    var table8 = $table8.DataTable({ 
                 columnDefs: [
      { className: 'never',
       "visible": false,
        "searchable": false,
       targets: [0,1,2] }
    ],
        responsive:true,
        language: {
            "sProcessing": "Traitement en cours ...",
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "Aucun résultat trouvé",
            "sEmptyTable": "Aucune donnée disponible",
            "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
            "sInfoEmpty": "Aucune ligne affichée",
            "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
            "sInfoPostFix": "",
            
            "sUrl": "",
            "sSearch":         "",
            //"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfoThousands": ",",
            "sLoadingRecords": "Chargement...",
            "oPaginate": {
                "sFirst": "Premier",
                "sLast": "Dernier",
                "sNext": "Suivant",
                "sPrevious": "Précédent"
            },
            "oAria": {
                "sSortAscending": ": Trier par ordre croissant",
                "sSortDescending": ": Trier par ordre décroissant"
            }
        },

        ajax : 'Controllers/partages.php',
        destroy: true,
        bStateSave: true,
       
    });
    table8.column( 0 ).visible( false );
    table8.column( 1 ).visible( false );
    table8.column( 2 ).visible( false );
    var table9 = $table9.DataTable({ 
        responsive:true,
        language: {
            "sProcessing": "Traitement en cours ...",
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "Aucun résultat trouvé",
            "sEmptyTable": "Aucune donnée disponible",
            "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
            "sInfoEmpty": "Aucune ligne affichée",
            "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
            "sInfoPostFix": "",
            
            "sUrl": "",
            "sSearch":         "",
            //"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfoThousands": ",",
            "sLoadingRecords": "Chargement...",
            "oPaginate": {
                "sFirst": "Premier",
                "sLast": "Dernier",
                "sNext": "Suivant",
                "sPrevious": "Précédent"
            },
            "oAria": {
                "sSortAscending": ": Trier par ordre croissant",
                "sSortDescending": ": Trier par ordre décroissant"
            }
        },
        destroy: true,
        bLengthChange: false,
        bFilter: false,
        bPaginate: true,
        pagingType: "simple",
        iDisplayLength: 5,
        bStateSave: true,
        
    });
    
    var table11 = $table11.DataTable({ responsive:true,
        
        
        language: {
            "sProcessing": "Traitement en cours ...",
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "Aucun résultat trouvé",
            "sEmptyTable": "Aucune donnée disponible",
            "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
            "sInfoEmpty": "Aucune ligne affichée",
            "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
            "sInfoPostFix": "",
            
            "sUrl": "",
            "sSearch":         "",
            //"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfoThousands": ",",
            "sLoadingRecords": "Chargement...",
            "oPaginate": {
                "sFirst": "Premier",
                "sLast": "Dernier",
                "sNext": "Suivant",
                "sPrevious": "Précédent"
            },
            "oAria": {
                "sSortAscending": ": Trier par ordre croissant",
                "sSortDescending": ": Trier par ordre décroissant"
            }
        },

        ajax : 'Controllers/taches.php',
        destroy: true,
        bStateSave: true,
       
    });
     var table12 = $table12.DataTable({ responsive:true,
         
        
        language: {
            "sProcessing": "Traitement en cours ...",
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "Aucun résultat trouvé",
            "sEmptyTable": "Aucune donnée disponible",
            "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
            "sInfoEmpty": "Aucune ligne affichée",
            "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
            "sInfoPostFix": "",
            
            "sUrl": "",
            "sSearch":         "",
            //"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfoThousands": ",",
            "sLoadingRecords": "Chargement...",
            "oPaginate": {
                "sFirst": "Premier",
                "sLast": "Dernier",
                "sNext": "Suivant",
                "sPrevious": "Précédent"
            },
            "oAria": {
                "sSortAscending": ": Trier par ordre croissant",
                "sSortDescending": ": Trier par ordre décroissant"
            }
        },

        ajax : 'Controllers/serveursfull.php',
        destroy: true,
        bStateSave: true,
       
    });
    var table13 = $table13.DataTable({
        
        language: {
            "sProcessing": "Traitement en cours ...",
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "Aucun résultat trouvé",
            "sEmptyTable": "Aucune donnée disponible",
            "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
            "sInfoEmpty": "Aucune ligne affichée",
            "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
            "sInfoPostFix": "",
            "sUrl": "",
            "sSearch":         "",
            //"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfoThousands": ",",
            "sLoadingRecords": "Chargement...",
            "oPaginate": {
                "sFirst": "Premier",
                "sLast": "Dernier",
                "sNext": "Suivant",
                "sPrevious": "Précédent"
            },
            "oAria": {
                "sSortAscending": ": Trier par ordre croissant",
                "sSortDescending": ": Trier par ordre décroissant"
            }
        },
        destroy: true,
        bLengthChange: false,
        bFilter: false,
        bPaginate: true,
        pagingType: "simple",
        iDisplayLength: 5,
        bStateSave: true,
        
    });
    
    
    table14 = $table14.DataTable({
                        columnDefs: [
      { className: 'never',
       "visible": false,
        "searchable": false,
       targets: 0 }
    ],
        responsive:true,
        language: {
            "sProcessing": "Traitement en cours ...",
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "Aucun résultat trouvé",
            "sEmptyTable": "Aucune donnée disponible",
            "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
            "sInfoEmpty": "Aucune ligne affichée",
            "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
            "sInfoPostFix": "",
            
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Chargement...",
            "sSearch":         "",
             //"sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "oPaginate": {
                "sFirst": "Premier",
                "sLast": "Dernier",
                "sNext": "Suivant",
                "sPrevious": "Précédent"
            },
            "oAria": {
                "sSortAscending": ": Trier par ordre croissant",
                "sSortDescending": ": Trier par ordre décroissant"
            }
        },
        ajax : 'Controllers/partages.php',
        destroy: true,
        bStateSave: true,
       
    });
    table14.column( 0 ).visible( false );
  $( window ).resize(function() {
    table1.responsive.recalc().columns.adjust();
    table2.responsive.recalc().columns.adjust();
      table3.responsive.recalc().columns.adjust();
      table8.responsive.recalc().columns.adjust();
      table11.responsive.recalc().columns.adjust();
      table12.responsive.recalc().columns.adjust();
      table14.responsive.recalc().columns.adjust();
});
    setInterval(function() {
        table1.ajax.reload(null, false);
        table2.ajax.reload(null, false);
        table3.ajax.reload(null, false);
        table8.ajax.reload(null, false);
        table11.ajax.reload(null, false);
        table12.ajax.reload(null, false);
        table14.ajax.reload(null, false);
    }, TABLE_REFRESH_RATE);
    
      $('#userrequesttable tbody').on('click', 'button', function() {
        id = table3.cell($(this).parents('tr') , 0).data();
        table5.ajax.url('Controllers/demandepermission.php?id=' + id);
        table5.ajax.reload(null, false);
    });
      $('#adminrequesttable tbody').on('click', 'button', function() {
        id = table2.cell($(this).parents('tr') , 0).data();
        var type = table2.cell($(this).parents('tr') , 1).data();
        pname = table2.cell($(this).parents('tr') , 3).data();
        quota = table2.cell($(this).parents('tr') , 6).data();
        selectedserver = table2.cell($(this).parents('tr'), 4).data();  
        $('#serveur').load('Controllers/serveurs.php');
        table5.ajax.url('Controllers/demandepermission.php?id=' + id);
        table5.ajax.reload(null, false);
        $table6.load('Controllers/editcollab.php?id='+id+'&type='+type, function() {
        xuser = $(this).children().length;
        $('input[name=id]').val(id);
        $('input[name=pname]').val(pname);
        $('input[name=quota]').val(quota);
        });
        $table7.load('Controllers/editcollab.php?id='+id+'&type='+type, function(data) {
        xuser = $(this).children().length;
        $('input[name=id]').val(id);
        $('input[name=pname]').val(pname);
        $('input[name=quota]').val(quota);
        });
    });
      $('#adminsharetable tbody').on('click', 'button', function() {
        id = table1.cell($(this).parents('tr') , 0).data();
        id_dem = table1.cell($(this).parents('tr') , 1).data();
        selectedserver = table1.cell($(this).parents('tr') , 3).data();
        selecteddisc =table1.cell($(this).parents('tr') , 4).data();
        quota = table1.cell($(this).parents('tr') , 6).data();
        pname = table1.cell($(this).parents('tr') , 10).data();
        table9.ajax.url('Controllers/partagepermission.php?id='+id);
        table9.ajax.reload(null, false);
          if (id_dem==0){
        $('.wrapper_edit_old_share_admin').load('Controllers/editsharecollab.php?id='+id+'&isold=true', function() {
        xuser = $(this).children().length;
        $('input[name=id]').val(id_dem);
        $('input[name=pname]').val(pname);
        $('input[name=quota]').val(quota);
        $('input[name=oldserver]').val(selectedserver);
        $('input[name=olddisc]').val(selecteddisc);
        });
              
          }else
        $('.wrapper_edit_share_admin').load('Controllers/editsharecollab.php?id='+id, function() {
        xuser = $(this).children().length;
        $('input[name=id]').val(id_dem);
        $('input[name=pname]').val(pname);
        $('input[name=quota]').val(quota);
        });
       


    });  
    
      $('#usersharetable tbody').on('click', 'button', function() {
        id = table8.cell($(this).parents('tr') , 0).data();
        pname = table8.cell($(this).parents('tr') , 2).data();
        quota = table8.cell($(this).parents('tr') , 6).data();
        selectedserver = table8.cell($(this).parents('tr') , 4).data();  
        table9.ajax.url('Controllers/partagepermission.php?id=' + id);
        table9.ajax.reload(null, false);
        $table10.load('Controllers/editsharecollab.php?id='+id, function() {
        xuser = $(this).children().length;
        $('input[name=id]').val(id);
        $('input[name=pname]').val(pname);
        $('input[name=quota]').val(quota);
        });
    });
    
         $('#serverstable tbody').on('click', 'button', function() {
        id = table12.cell($(this).parents('tr') , 0).data();
        sname = table12.cell($(this).parents('tr') , 1).data();
        login = table12.cell($(this).parents('tr') , 3).data();
        pass = table12.cell($(this).parents('tr') , 4).data();
        table13.ajax.url('Controllers/discsfull.php?server='+sname);
        table13.ajax.reload(null, false);
        $('input[name=id]').val(id);
        $('input[name=sname]').val(sname);
        $('input[name=login]').val(login);
        $('input[name=pass]').val(pass); 
    });
        $('#taskstable tbody').on('click', 'button', function() {
        id = table11.cell($(this).parents('tr') , 0).data();
    });
    $('#techsharetable tbody').on('click', 'button', function() {
        id = table14.cell($(this).parents('tr') , 0).data();
        table9.ajax.url('Controllers/partagepermission.php?id='+id);
        table9.ajax.reload(null, false);
    });
    
    

   
$( ".modal" ).each(function (){
    $(this).on('hidden.bs.modal', function () {
        
    resetfields();
})
}); 
    
    $('#createshareform').on('show.bs.modal', function () {
         $('#serveurshare').load('Controllers/serveurs.php');
})
    $('#createserver').on('show.bs.modal', function () {
           resetfields();
})
    $('#createshareform').on('show.bs.modal', function () {
           resetfields();
})
        $('#createrequestform').on('show.bs.modal', function () {
           resetfields();
})
    
    
    
    
    $('#editshareadminform').on('shown.bs.modal', function () {
        var partage = $('#pnameeditshareadmin').val();
        var serveur = selectedserver;
        if((serveur!=null && serveur!='en attente') && partage!='')
        $('#verifeditshareadmin').load('Controllers/verifypname.php?server='+serveur+'&pname='+partage,function (data){
            if(data=='<span class="glyphicon glyphicon-remove" style="color:red;">')formpass=false;else formpass=true;
        
        });
})
    $('#editshareuserform').on('shown.bs.modal', function () {
        var partage = $('#pnameeditshareuser').val();
        var serveur = selectedserver;
        if((serveur!=null && serveur!='en attente') && partage!='')
        $('#verifeditshareuser').load('Controllers/verifypname.php?server='+serveur+'&pname='+partage,function (data){
            if(data=='<span class="glyphicon glyphicon-remove" style="color:red;">')formpass=false;else formpass=true;
        
        });
    })
    
   
    
    $('#pnamecreateshare').on('change', function() {
        var partage = $(this).val();
        var serveur = $('#serveurshare').val();
        if((serveur!=null && serveur!='en attente') && partage!='')
        $('#verifcreateshare').load('Controllers/verifypname.php?server='+serveur+'&pname='+partage,function (data){
            if(data=='<span class="glyphicon glyphicon-remove" style="color:red;">')formpass=false;else formpass=true;
        
        });
    });
   $("#pnameeditshareadmin").on('change',function(){
        var partage = $(this).val();
        var serveur = selectedserver;
        if((serveur!=null && serveur!='en attente') && partage!='')
        $('#verifeditshareadmin').load('Controllers/verifypname.php?server='+serveur+'&pname='+partage,function (data){
            if(data=='<span class="glyphicon glyphicon-remove" style="color:red;">')formpass=false;else formpass=true;
        
        });
   })
    $("#pnameeditshareuser").on('change',function(){
        var partage = $(this).val();
        var serveur = selectedserver;
        if((serveur!=null && serveur!='en attente') && partage!='')
        $('#verifeditshareuser').load('Controllers/verifypname.php?server='+serveur+'&pname='+partage,function (data){
            if(data=='<span class="glyphicon glyphicon-remove" style="color:red;">')formpass=false;else formpass=true;
        
        });
   })
       $("#pnameapprovemodifadmin").on('change',function(){
        var partage = $(this).val();
        var serveur = selectedserver;
        if((serveur!=null && serveur!='en attente') && partage!='')
        $('#verifapprovemodifadmin').load('Controllers/verifypname.php?server='+serveur+'&pname='+partage,function (data){
            if(data=='<span class="glyphicon glyphicon-remove" style="color:red;">')formpass=false;else formpass=true;
        
        });
   })
  
        $("#pnameacceptrequestadmin").on('change',function(){
        var partage = $(this).val();
        var serveur = $('#serveur').val();
        if((serveur!=null && serveur!='en attente') && partage!='')
        $('#verifacceptrequestadmin').load('Controllers/verifypname.php?server='+serveur+'&pname='+partage,function (data){
            if(data=='<span class="glyphicon glyphicon-remove" style="color:red;">')formpass=false;else formpass=true;
        });
   })
    $('#serveur').on('change', function() {
        $('.discchoose').load('Controllers/discstats.php');
        $('#disque').load("Controllers/disques.php?server=" + $(this).val());
        if($(this).val()!=null && $('#pnameacceptrequestadmin').val()!='' ){
        $('#verifacceptrequestadmin').load('Controllers/verifypname.php?server='+$(this).val()+'&pname='+$('#pnameacceptrequestadmin').val(),function (data){
            if(data=='<span class="glyphicon glyphicon-remove" style="color:red;">')formpass=false;else formpass=true;
        });
    }
    });
    
     $('#serveurshare').on('change', function() {
        $('.discchooseshare').load('Controllers/discstats.php');
        $('#disqueshare').load("Controllers/disques.php?server=" + $(this).val());
         if($(this).val()!=null && $('#pnamecreateshare').val()!='' ){
        $('#verifcreateshare').load('Controllers/verifypname.php?server='+$(this).val()+'&pname='+$('#pnamecreateshare').val(),function (data){
            if(data=='<span class="glyphicon glyphicon-remove" style="color:red;">')formpass=false;else formpass=true;
        });
     }
    });
    $('#type_dem').on('change', function() {
        type_dem = $(this).val();
        table3.ajax.url('Controllers/demandes.php?type=' + type_dem);
        table3.ajax.reload(null, false);
    });
    $('#disque').on('change', function() {
        $('.discchoose').load('Controllers/discstats.php?server='+ $('#serveur').val() +'&drive='+ $(this).val(),function(){
            });
    });
    
    $('#disqueshare').on('change', function() {
        $('.discchooseshare').load('Controllers/discstats.php?server='+ $('#serveurshare').val() +'&drive='+ $(this).val(),function () {
        });
       
    });
    

    $('#type_dem_admin').on('change', function() {
        type_dem = $(this).val();
        table2.ajax.url('Controllers/demandes.php?type=' + type_dem);
        table2.ajax.reload(null, false);
    });
    setInterval(function() {
        getnotifications();
    }, NOTIFICATIONS_REFRESH_RATE);
    
    function resetfields() {
    xuser=0;
    formpass=true;
    $('.discchoose').load('Controllers/discstats.php');
    $('.discchooseshare').load('Controllers/discstats.php');
    $('#serveur').load('Controllers/serveurs.php');
    $('#serveurshare').load('Controllers/serveurs.php');
    $('#disque').load('Controllers/disques.php');
    $('#disqueshare').load('Controllers/disques.php');
    $(".input_fields_wrap").empty();
    $(".wrapper_edit_share_user").empty();    
    $(".wrapperadmin").empty();
    $(".wrapperapprovemodifadmin").empty();
    $(".wrapper_edit_share_admin").empty();
    $(".wrapper_create_share").empty(); 
    $('#verifcreateshare').empty();
    $('#verifeditshareadmin').empty();
    $('#verifeditshareuser').empty();
    $('#verifacceptrequestadmin').empty();
    $('input[name=id]').val('');
    $('input[name=pname]').val('');
    $('input[name=quota]').val('');
    $('input[name=sname]').val('');
    $('input[name=login]').val('');
    $('input[name=pass]').val('');
    $('input[name=oldserver]').val('');
    $('input[name=olddisc]').val('');
}
    //wrappers
    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID

    var xuser = 0; //initlal text box count
    $(add_button).click(function(e) { //on add input button click
        e.preventDefault();
        if (xuser < max_fields) { //max input box allowed
            $(wrapper).append('<tr><div class="form-group" ><td><input type="text" name="collabs[]" class="form-control" min="0" required></td><td> <input type="checkbox"   name="permissions[]" value="FULL" style="margin-right:6px;">FULL<input type="checkbox"   name="permissions[]" value="READ" checked style="margin-left:10px;margin-right:6px;">READ</td><td><a class="btn btn-danger remove_field"><span class="glyphicon glyphicon-remove"></span></a></td></div></tr>'); //add input box
            xuser++; //text box increment
        }
    });

    $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
        e.preventDefault();
        $(this).parent('td').parent('tr').remove();
        xuser--;

    });



    var wrapperuser = $(".wrapperadmin"); //Fields wrapper
    var addbuttonaaprovecreate = $(".add_field_button_approve_create");

    $(addbuttonaaprovecreate).click(function(e) { //on add input button click
        e.preventDefault();
        
        if (xuser < max_fields) { //max input box allowed
            $(wrapperuser).append('<tr><div class="form-group" ><td><input type="text" name="collabs[]" class="form-control" min="0" required></td><td> <input type="checkbox"   name="permissions[]" value="FULL" style="margin-right:6px;">FULL<input type="checkbox"   name="permissions[]" value="READ" checked style="margin-left:10px;margin-right:6px;">READ</td><td><a class="btn btn-danger remove_field_approve_create"><span class="glyphicon glyphicon-remove"></span></a></td></div></tr>'); //add input box
            xuser++; //text box increment
        }
    });

    $(wrapperuser).on("click", ".remove_field_approve_create", function(e) { //user click on remove text
        e.preventDefault();
        $(this).parent('td').parent('tr').remove();
        xuser--;

    });
    
    var wrapperapprovemodif = $(".wrapperapprovemodifadmin"); //Fields wrapper
    var add_button_modif = $(".add_field_button_modif"); //Add button ID

    $(add_button_modif).click(function(e) { //on add input button click
        e.preventDefault();
        if (xuser < max_fields) { //max input box allowed
            $(wrapperapprovemodif).append('<tr><div class="form-group" ><td><input type="text" name="collabs[]" class="form-control" min="0" required></td><td> <input type="checkbox"   name="permissions[]" value="FULL" style="margin-right:6px;">FULL<input type="checkbox"   name="permissions[]" value="READ" checked style="margin-left:10px;margin-right:6px;">READ</td><td><a class="btn btn-danger remove_field_modif"><span class="glyphicon glyphicon-remove"></span></a></td></div></tr>'); //add input box
            xuser++; //text box increment
        }
    });

    $(wrapperapprovemodif).on("click", ".remove_field_modif", function(e) { //user click on remove text
        e.preventDefault();
        $(this).parent('td').parent('tr').remove();
        xuser--;

    });
    
    
    
    var wrapper_create_share = $(".wrapper_create_share"); //Fields wrapper
    var add_button_create_share = $(".add_create_share"); //Add button ID

    $(add_button_create_share).click(function(e) { //on add input button click
        e.preventDefault();
        if (xuser < max_fields) {
            //max input box allowed
            $(wrapper_create_share).append('<tr><div class="form-group" ><td><input type="text" name="collabs[]" class="form-control" min="0" required></td><td> <input type="checkbox"   name="permissions[]" value="FULL" style="margin-right:6px;">FULL<input type="checkbox"   name="permissions[]" value="READ" checked style="margin-left:10px;margin-right:6px;">READ</td><td><a class="btn btn-danger remove_field_create_share"><span class="glyphicon glyphicon-remove"></span></a></td></div></tr>'); //add input box
            xuser++; //text box increment
        }
    });

    $(wrapper_create_share).on("click", ".remove_field_create_share", function(e) { //user click on remove text
        e.preventDefault();
        $(this).parent('td').parent('tr').remove();
        xuser--;

    });

    
    
    var wrappereditshareadmin = $(".wrapper_edit_share_admin"); //Fields wrapper
    var add_button_edit_share_admin = $(".add_button_edit_share_admin"); //Add button ID

    $(add_button_edit_share_admin).click(function(e) { //on add input button click
        e.preventDefault();
        if (xuser < max_fields) { //max input box allowed
            $(wrappereditshareadmin).append('<tr><div class="form-group" ><td><input type="text" name="collabs[]" class="form-control" min="0" required></td><td> <input type="checkbox"   name="permissions[]" value="FULL" style="margin-right:6px;">FULL<input type="checkbox"   name="permissions[]" value="READ" checked style="margin-left:10px;margin-right:6px;">READ</td><td><a class="btn btn-danger remove_field_edit_share_admin"><span class="glyphicon glyphicon-remove"></span></a></td></div></tr>'); //add input box
            xuser++; //text box increment
        }
    });

    $(wrappereditshareadmin).on("click", ".remove_field_edit_share_admin", function(e) { //user click on remove text
        e.preventDefault();
        $(this).parent('td').parent('tr').remove();
        xuser--;

    });
    
     var wrappereditshareuser = $(".wrapper_edit_share_user"); //Fields wrapper
    var add_button_edit_share_user = $(".add_field_edit_share_user"); //Add button ID

    $(add_button_edit_share_user).click(function(e) { //on add input button click
        e.preventDefault();
        if (xuser < max_fields) { //max input box allowed
            $(wrappereditshareuser).append('<tr><div class="form-group" ><td><input type="text" name="collabs[]" class="form-control" min="0" required></td><td> <input type="checkbox"   name="permissions[]" value="FULL" style="margin-right:6px;">FULL<input type="checkbox"   name="permissions[]" value="READ" checked style="margin-left:10px;margin-right:6px;">READ</td><td><a class="btn btn-danger remove_field_edit_share_user"><span class="glyphicon glyphicon-remove"></span></a></td></div></tr>'); //add input box
            xuser++; //text box increment
        }
    });

    $(wrappereditshareuser).on("click", ".remove_field_edit_share_user", function(e) { //user click on remove text
        e.preventDefault();
        $(this).parent('td').parent('tr').remove();
        xuser--;

    });
    
    var wrappereditoldshare = $(".wrapper_edit_old_share_admin"); //Fields wrapper
    var add_button_edit_old_share = $(".add_button_edit_old_share_admin"); //Add button ID

    $(add_button_edit_old_share).click(function(e) { //on add input button click
        e.preventDefault();
        if (xuser < max_fields) { //max input box allowed
            $(wrappereditoldshare).append('<tr><div class="form-group" ><td><input type="text" name="collabs[]" class="form-control" min="0" required></td><td> <input type="checkbox"   name="permissions[]" value="FULL" style="margin-right:6px;">FULL<input type="checkbox"   name="permissions[]" value="READ" checked style="margin-left:10px;margin-right:6px;">READ</td><td><a class="btn btn-danger remove_field_edit_old_share"><span class="glyphicon glyphicon-remove"></span></a></td></div></tr>'); //add input box
            xuser++; //text box increment
        }
    });

    $(wrappereditoldshare).on("click", ".remove_field_edit_old_share", function(e) { //user click on remove text
        e.preventDefault();
        $(this).parent('td').parent('tr').remove();
        xuser--;

    });
    //


$( ".modal" ).on('shown.bs.modal',function() {
    setInterval(function (){
            $( "input[type=checkbox]" ).on('change',function () {

    if (!$(this).is(':checked'))$(this).siblings().prop('checked', true);
   else $(this).siblings().prop('checked', false);
        
});
    },500);


  
}); 
    
    setInterval(function (){
         $.post("Controllers/calculatespace.php",
    {
        
    },function (){}
                              );
                    
    },5000);
 
        
});
function refreshtech(){
      table14.ajax.url('Controllers/partages.php?matcollab='+$('input[name=matcollab]').val());
      table14.ajax.reload(null, false);
}
    
     $("#formulaireeditshareuser").submit(function(event) {
        if(formpass){
      /* stop form from submitting normally */
      event.preventDefault();
    
            url : 'Controllers/modifrequestuser.php',
         
     $('#editshareuserform').modal('hide');
            }
        else {
            
                changename();
                return false;
            }
        
});
    
    $("#formulaireacceptmodif").submit(function(event) {
        if(formpass){
      /* stop form from submitting normally */
      event.preventDefault();
        $("#formulaireacceptmodif").ajaxSubmit(
        {
            url : 'Controllers/approvemodif.php',
            type : 'POST',
            success : successful,
            error : echec
        });   
     $('#adminacceptmodifform').modal('hide');
            }
        else {
            
                changename();
                return false;
            }
        
});
    $("#dcreateshare").submit(function(event) {
        if(formpass){
      /* stop form from submitting normally */
      event.preventDefault();
        $("#dcreateshare").ajaxSubmit(
        {
            url : 'Controllers/createshare.php',
            type : 'POST',
            success : successful,
            error : echec
        });   
     $('#createshareform').modal('hide');
            }
        else {
            
                changename();
                return false;
            }
        
});
        $("#editoldshare").submit(function(event) {
      /* stop form from submitting normally */
      event.preventDefault();
        $("#editoldshare").ajaxSubmit(
        {
            url : 'Controllers/editoldshare.php',
            type : 'POST',
            success : successful,
            error : echec
        });   
     $('#editoldsharemodal').modal('hide');        
});
    
    
        $("#formulairecreaterequest").submit(function(event) {
        
      /* stop form from submitting normally */
      event.preventDefault();
        $("#formulairecreaterequest").ajaxSubmit(
        {
            url : 'Controllers/createrequestform.php',
            type : 'POST',
            success : successful,
            error :  echec
        });   
     $('#createrequestform').modal('hide');
            
        
});
        $("#createserverform").submit(function(event) {
        
      /* stop form from submitting normally */
            event.preventDefault();
        $("#createserverform").ajaxSubmit(
        {
            url : 'Controllers/createserver.php',
            type : 'POST',
            success : successful,
            error :  echec
        });   
     $('#createserver').modal('hide');
            
        
});
    
            $("#editserverform").submit(function(event) {
        
      /* stop form from submitting normally */
            event.preventDefault();
        $("#editserverform").ajaxSubmit(
        {
            url : 'Controllers/editserver.php',
            type : 'POST',
            success : successful,
            error :  echec
        });
        
     $('#editserver').modal('hide');
            
        
});
           $("#editshare").submit(function(event) {
        
      /* stop form from submitting normally */
            event.preventDefault();
        $("#editshare").ajaxSubmit(
        {
            url : 'Controllers/editshare.php',
            type : 'POST',
            success : successful,
            error :  echec
        });   
     $('#editshareadminform').modal('hide');
            
        
});

    
    

            $("#acceptcrequestform").submit(function(event) {
      /* stop form from submitting normally */
      event.preventDefault();
        if(formpass){
            
            
                $("#acceptcrequestform").ajaxSubmit(
        {
            url : 'Controllers/acceptcreaterequestform.php',
            type :'POST',
            success: successful,
            error: echec
        }); 
    
                 $('#adminacceptform').modal('hide');
            }
        else {
            
                changename();
                return false;
            }
    
        
});  
    
    
 
function echec(){
$.dialog({
                    type: 'red',
                    typeAnimated: true,
                    title: 'Echec !!',
                    icon: 'glyphicon glyphicon-remove',
                    content: 'Echec de l\'opération !!',
    });
}

function successful(){
$.dialog({
                    type: 'green',
                    typeAnimated: true,
                    title: 'Success!',
                    icon: 'glyphicon glyphicon-ok',
                    content: 'Opération effectuée',
    });
}
function changename(){
            $.dialog({
                    type: 'orange',
                    typeAnimated: true,
                    icon: '	glyphicon glyphicon-refresh',
        title: 'Attention!',
        content: 'Changer le nom du partage !!!',
    });
}

function toasterinitclearall() {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        //"preventDuplicates": true,
        "hideDuration": "1000",
        "timeOut": 0,
        "extendedTimeOut": 0,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "tapToDismiss": 'true',
    }
}

function dismissnotif(id) {
    $.ajax({
        type: 'POST',
        url: 'Controllers/notifications.php',
        data :{
        'dropid' : id,
        },
        success: function(data){
        },
        error: function(){
    }
    });
}



function clearnotifs() {
    toastr.clear();
}



//functions



    var dismiss= [];
    var clearall='init';
function getnotifications() {
    toasterinitclearall();
    $.ajax({
        type: 'POST',
        url: 'Controllers/notifications.php',
        dataType: "json",
        async: true,
        success: function(data) {
            $.each(data, function(key, value) {
                
                value = value.toString();
                var tab = value.split(',');
                if(dismiss.indexOf(tab[0])== -1)
                {
                    if (clearall == 'init') {
                    toastr.info('Clear All','',{onclick : function() {
                         for(var i= 0; i < dismiss.length; i++)
                    {
                        dismissnotif(dismiss[i]);
                    }
                        toastr.clear();
                        clearall='init';
                    }});
                    clearall = 'true';
                }
                dismiss.push(tab[0]);
                if (tab[3].toUpperCase()== 'ERROR') {
                    toastr.error(tab[2],'',{
                        onclick: function() {
                            dismissnotif(tab[0]);
                            var index = dismiss.indexOf(tab[0]);
                            dismiss.splice(index, 1);
                            
                        }
                    });

                } else if (tab[3].toUpperCase()== 'SUCCESS') {
                    toastr.success(tab[2],'',{
                        onclick: function() {
                            dismissnotif(tab[0]);
                            var index = dismiss.indexOf(tab[0]);
                            dismiss.splice(index, 1);
                        }
                    });

                } else if (tab[3].toUpperCase()== 'INFO') {
                    toastr.info(tab[2],'',{
                        onclick: function() {
                            dismissnotif(tab[0]);
                            var index = dismiss.indexOf(tab[0]);
                            dismiss.splice(index, 1);
                            
                        }
                    });
                } else {
                    toastr.warning(tab[2],'',{
                        onclick: function() {
                            dismissnotif(tab[0]);
                            var index = dismiss.indexOf(tab[0]);
                            dismiss.splice(index, 1);
                            
                        }
                    });
                }
                }
            });
                
                
        },

        error: function(error) {}
    }
          );
    if (dismiss.length==0) toastr.clear();

}



    //confirm dialogs
function exectasks() {
    $.post("scheudledtasks/backgroundtasks.php",
    {
    },
    successful()
                              );
    


}
function scandrives(){
  $.post("scheudledtasks/scanserver.php",
    {
    },
    successful()
                              );
}
function scanshares(){
    $.post("scheudledtasks/listshares.php",
    {
    },
    successful()
                              );
}

function confirmer() {
    $.confirm({
        title: 'Attention!',
        content: 'Confirmer la Suppression ?',
        buttons: {
            confirm: {
                text: 'Supprimer',
                btnClass: 'btn-red',
                action: function() {}
            },
            cancel: {
                text: 'Annuler',
                btnClass: 'btn-grey',
                action: function() {}
            }
        }
    });


}

function confirmdelete() {
    $.confirm({
        title: 'Attention!',
        content: 'Confirmer la Suppression ?',
        buttons: {
            confirm: {
                text: 'Supprimer',
                btnClass: 'btn-red',
                action: function() {
                    $.post("Controllers/confirmdeleterequest.php",
    {
        'id': id,
    },
    successful()
                              );
                    
                
                }
            },
            cancel: {
                text: 'Annuler',
                btnClass: 'btn-grey',
                action: function() {}
            }
        }
    });


}



function refuserdemande() {
    $.confirm({
        title: 'Attention!',
        content: 'Confirmer le Refus ?',
        buttons: {
            confirm: {
                text: 'Refuser',
                btnClass: 'btn-red',
                action: function() {
                
                        $.ajax({
        type: 'GET',
        url: 'Controllers/refuserdemande.php?id='+id,
        async: true,
        success: function(){
            
        }
                        
                        
                        })
                
                
                }
            },
            cancel: {
                text: 'Annuler',
                btnClass: 'btn-grey',
                action: function() {}
            }
        }
    });


}

function removeserver() {
    $.confirm({
        title: 'Attention!',
        content: 'Confirmer la Suppression ?',
        buttons: {
            confirm: {
                text: 'Supprimer',
                btnClass: 'btn-red',
                action: function() {
                
                        $.post("Controllers/deleteserver.php",
    {
        'id': id,
    },
    successful()
                              );
                    
                        
                        
                
                
                }
            },
            cancel: {
                text: 'Annuler',
                btnClass: 'btn-grey',
                action: function() {}
            }
        }
    });


}
 function relancertask(){
         $.confirm({
        title: 'Attention!',
        content: 'Confirmer la relance ?',
        buttons: {
            confirm: {
                text: 'Relancer',
                btnClass: 'btn-primary',
                action: function() {
                    $.ajax(
        {
            url : 'Controllers/relancertask.php?id='+id,
            type :'GET',
            success: successful,
            error: echec
        }); 
                }
            },
            cancel: {
                text: 'Annuler',
                btnClass: 'btn-grey',
                action: function() {}
            }
        }
    });
    
    }  

function deleteshare () {
    
            $.confirm({
        title: 'Attention!',
        content: 'Confirmer la Suppression ?',
        buttons: {
            confirm: {
                text: 'Supprimer',
                btnClass: 'btn-red',
                action: function() {
                    $.post("Controllers/deleteshare.php",
    {
        'id': id_dem,
    },
    successful()
                              );
                    
                
                }
            },
            cancel: {
                text: 'Annuler',
                btnClass: 'btn-grey',
                action: function() {}
            }
        }
    });
        
        
    }

function deleterequestcreate(){
    
        $.confirm({
        title: 'Attention!',
        content: 'Confirmer la Suppression ?',
        buttons: {
            confirm: {
                text: 'Supprimer',
                btnClass: 'btn-red',
                action: function() {
                
                        $.post("Controllers/deleterequestbfapprove.php",
    {
        'id': id,
    },
    successful()
                              );
                    
                        
                        
                
                
                }
            },
            cancel: {
                text: 'Annuler',
                btnClass: 'btn-grey',
                action: function() {}
            }
        }
    });

    
    
}

function deleterequest(){
    
        $.confirm({
        title: 'Attention!',
        content: 'Confirmer la Suppression ?',
        buttons: {
            confirm: {
                text: 'Supprimer',
                btnClass: 'btn-red',
                action: function() {
                
                        $.post("Controllers/deleterequestuser.php",
    {
        'id': id_dem,
    },
    successful()
                              );
                    
                        
                        
                
                
                }
            },
            cancel: {
                text: 'Annuler',
                btnClass: 'btn-grey',
                action: function() {}
            }
        }
    });

    
    
}
function deleteoldshare(){
     $.confirm({
        title: 'Attention!',
        content: 'Confirmer la Suppression ?',
        buttons: {
            confirm: {
                text: 'Supprimer',
                btnClass: 'btn-red',
                action: function() {
                    $.post("Controllers/deleteoldshare.php",
    {
        'server': selectedserver,
        'disc' : selecteddisc,
        'pname': pname
    },
    successful()
                              );
                    
                
                }
            },
            cancel: {
                text: 'Annuler',
                btnClass: 'btn-grey',
                action: function() {}
            }
        }
    });
        
    
    
}
function blocker () {
    
            $.confirm({
        title: 'Attention!',
        content: 'Confirmer le Blocage ?',
        buttons: {
            confirm: {
                text: 'Bloquer',
                btnClass: 'btn-red',
                action: function() {
                    $.post("Controllers/blockshare.php",
    {
        'id': id_dem,
    },
    successful()
                              );
                    
                
                }
            },
            cancel: {
                text: 'Annuler',
                btnClass: 'btn-grey',
                action: function() {}
            }
        }
    });
        
        
    }