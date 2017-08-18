<div class="tab-pane <?php if(isset($useractive)) echo $useractive; ?>" id="userrequest">
	<section class="panel">
		<header class="panel-heading form-inline">
			Mes Demandes
            <button type="button" class="btn btn-info btn-xs" style="margin-left:25px;" data-toggle="modal" data-target="#createrequestform">
									+ Nouveau Partage
								</button><br/><br/>
            Type:
            <select id="type_dem" style="width:135px;margin-left:5px;" class="form-control">
      <option value='c' selected>création</option>
      <option value='m' >Modification</option>
    <option value='s' >Suppression</option>
    </select>
            <br/>
            
		</header>

			<table class="table table-striped table-bordered text-center" id="userrequesttable" width="100%">
				<thead>
					<tr>
						<th class="">
							id
						</th>
                        <th class="">
                            type
                        </th>
						<th class="">
							Demandeur
						</th>
						<th class="text-center">
                            Nom Partage		
						</th>
						<th class="">
							Serveur
						</th>
						<th class="">
							Disque
						</th>
						<th class="text-center">
							Quota
						</th>
						<th class="text-center" width="10%">
							Collaborateurs
						</th>
						<th class="text-center" width="10%">
							Etat
						</th>
						<th class="text-center">
							Action
						</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
	</section>
</div>
<div class="tab-pane" id="usershare">
	<section class="panel">
		<header class="panel-heading">
			mes partages
		</header>
		<div class="table-responsive">
			<table class="text-center table table-striped m-b-none" id="usersharetable" width="100%">
				<thead>
					<tr>
                        <th class="">
							id
						</th>
				        <th style="">id demande</th>
						<th class="text-center">
								Nom Partage
						</th>
						<th class="">
							Serveur
						</th>
						<th class="">
							Disque
						</th>
                        <th class="text-center">
							Taille actuelle
						</th>
						<th class="text-center">
							Quota
						</th>
						<th class="text-center" width="10%">
							Collaborateurs
						</th>
						<th class="text-center" width="10%">
							Etat
						</th>
						<th class="text-center" width="10%">
							Action
						</th>
						
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</section>
</div>