
<!-- Navigation bar -->
<ul class="nav nav-tabs" data-tabs="tabs" id="maintabs">
    <li class="active"><a data-toggle="tab" href="#general">{{ lang._('General') }}</a></li>
    <li><a data-toggle="tab" href="#groups">{{ lang._('Groups') }}</a></li>
    <li><a data-toggle="tab" href="#clists">{{ lang._('Lists') }}</a></li>
</ul>

<div class="tab-content content-box tab-content">
    <div id="general" class="tab-pane fade in active">
        <div class="content-box" style="padding-bottom: 1.5em;">
            {{ partial("layout_partials/base_form",['fields':generalForm,'id':'frm_general_settings'])}}
            <div class="col-md-12 __mt">
                <button class="btn btn-primary" id="saveAct" type="button"><b>{{ lang._('Save') }}</b> <i id="saveAct_progress"></i></button>
            </div>
        </div>
    </div>
    <div id="groups" class="tab-pane fade in">
        <div id="groups-area" class="table-responsive">
            <table id="grid-groups" class="table table-condensed table-hover table-striped" data-editDialog="dialogEditE2guardianGroup">
                <thead>
                    <tr>
                        <th data-column-id="enabled" data-type="string" data-formatter="rowtoggle" data-sortable="false">{{ lang._('Enabled') }}</th>
                        <th data-column-id="instance"  data-visible="true" data-sortable="false" data-order="asc">{{ lang._('Instance') }}</th>
                        <th data-column-id="groupname" data-type="string" data-visible="true" data-sortable="false">{{ lang._('Name') }}</th>
                        <th data-column-id="commands" data-formatter="commands" data-sortable="false">{{ lang._('Commands') }}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td>
                            <button data-action="add" type="button" class="btn btn-xs btn-default"><span class="fa fa-plus"></span></button>

                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-md-12">
            <hr />
            <button class="btn btn-primary" id="saveAct_group" type="button"><b>{{ lang._('Save') }}</b> <i id="saveAct_group_progress"></i></button>
            <br /><br />
        </div>
    </div>
    <div id="clists" class="tab-pane fade in">
            <div id="clists-area" class="table-responsive">
                <table id="grid-clists" class="table table-condensed table-hover table-striped" data-editDialog="dialogEditE2guardianClist">
                    <thead>
                        <tr>
                            <th data-column-id="enabled" data-type="string" data-formatter="rowtoggle">{{ lang._('Enabled') }}</th>
                            <th data-column-id="listtype" data-type="string" data-visible="true">{{ lang._('Type') }}</th>
                            <th data-column-id="listname" data-type="string" data-visible="true">{{ lang._('Name') }}</th>
                            <th data-column-id="commands" data-formatter="commands" data-sortable="false">{{ lang._('Commands') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td>
                                <button data-action="add" type="button" class="btn btn-xs btn-default"><span class="fa fa-plus"></span></button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-12">
                <hr />
                <button class="btn btn-primary" id="saveAct_clist" type="button"><b>{{ lang._('Save') }}</b> <i id="saveAct_clist_progress"></i></button>
                <br /><br />
            </div>
    </div>
</div>

{{ partial("layout_partials/base_dialog",['fields':formDialogEditE2guardianGroup,'id':'dialogEditE2guardianGroup','label':lang._('Edit group')])}}
{{ partial("layout_partials/base_dialog",['fields':formDialogEditE2guardianClist,'id':'dialogEditE2guardianClist','label':lang._('Edit list')])}}

<style>
    #grid-groups .command-delete {
        display: none; /* Скрыть кнопку по умолчанию */
    }

    #grid-groups tbody tr:last-child .command-delete {
        display: inline-block; /* Показать кнопку только в последней строке */
    }
</style>

<script>
$(document).ready(function() {
    let data_get_map = {
        'frm_general_settings': "/api/e2guardian/general/get"
    };
    mapDataToFormUI(data_get_map).done(function(data) {
        formatTokenizersUI();
        $('.selectpicker').selectpicker('refresh');
    });

    updateServiceControlUI('e2guardian');

    $("#saveAct").click(function() {
        saveFormToEndpoint(url = "/api/e2guardian/general/set", formid = 'frm_general_settings', callback_ok = function() {
            $("#saveAct_progress").addClass("fa fa-spinner fa-pulse");
            ajaxCall(url = "/api/e2guardian/service/reconfigure", sendData = {}, callback = function(data, status) {
                updateServiceControlUI('e2guardian');
                $("#saveAct_progress").removeClass("fa fa-spinner fa-pulse");
            });
        });
    });

    $("#grid-groups").UIBootgrid({
        search: '/api/e2guardian/group/searchGroup',
        get: '/api/e2guardian/group/getGroup/',
        set: '/api/e2guardian/group/setGroup/',
        add: '/api/e2guardian/group/addGroup/',
        del: '/api/e2guardian/group/delGroup/',
        toggle: '/api/e2guardian/group/toggleGroup/'
    });

    $("#saveAct_group").click(function() {
        saveFormToEndpoint(url = "/api/e2guardian/group/set", formid = 'frm_general_settings', callback_ok = function() {
            $("#saveAct_group_progress").addClass("fa fa-spinner fa-pulse");
            ajaxCall(url = "/api/e2guardian/service/reconfigure", sendData = {}, callback = function(data, status) {
                updateServiceControlUI('e2guardian');
                $("#saveAct_group_progress").removeClass("fa fa-spinner fa-pulse");
            });
        });
    });

    $("#grid-clists").UIBootgrid({
            search: '/api/e2guardian/clist/searchClist',
            get: '/api/e2guardian/clist/getClist/',
            set: '/api/e2guardian/clist/setClist/',
            add: '/api/e2guardian/clist/addClist/',
            del: '/api/e2guardian/clist/delClist/',
            toggle: '/api/e2guardian/clist/toggleClist/'
        });

        $("#saveAct_clist").click(function() {
            saveFormToEndpoint(url = "/api/e2guardian/clist/set", formid = 'frm_general_settings', callback_ok = function() {
                $("#saveAct_clist_progress").addClass("fa fa-spinner fa-pulse");
                ajaxCall(url = "/api/e2guardian/service/reconfigure", sendData = {}, callback = function(data, status) {
                    updateServiceControlUI('e2guardian');
                    $("#saveAct_clist_progress").removeClass("fa fa-spinner fa-pulse");
                });
            });
        });

    // update history on tab state and implement navigation
    if (window.location.hash != "") {
        $('a[href="' + window.location.hash + '"]').click()
    }
    $('.nav-tabs a').on('shown.bs.tab', function(e) {
        history.pushState(null, null, e.target.hash);
    });
});
</script>
