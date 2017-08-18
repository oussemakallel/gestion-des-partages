
			<div class="tab-pane" id="adminshare">
				<section class="panel">
					<header class="panel-heading">
						Partages
                        
                         <button type="button" class="btn btn-info btn-xs" style="margin-left:25px;"  data-toggle="modal" data-target="#createshareform" >
									+ Nouveau Partage
								</button><br/><br/>
					</header>
					
						<table class="text-center table table-striped table-bordered m-b-none" id="adminsharetable" width="100%">
							<thead>
								<tr>
				        <th class="text-center" width="5%">id</th>
                        <th style="">id demande</th>
						<th class="text-center" width="17%"> @ Adresse Réseau</th>
						<th class="">Serveur</th>
						<th class="">Disque</th>
                        <th class="text-center" width="15%">
							Taille actuelle
						</th>
						<th class="text-center" width="7%">
							Quota
						</th>
						<th class="text-center" width="10%">
							Collaborateurs
						</th>
						<th class="text-center" width="10%">
							Etat
						</th>
						<th class="text-center" width="36%">
							Action
                        </th>
                        <th style="">Partage</th>
                        
						
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					
				</section>
			</div>
        <div class="tab-pane" id="servers">
				<section class="panel">
					<header class="panel-heading">
                        Serveurs
                         <button type="button" class="btn btn-info btn-xs" style="margin-left:25px;" data-toggle="modal" data-target="#createserver">
									+ Nouveau Serveur
								</button>
					</header>
					
						<table id="serverstable" class="text-center table table-striped table-bordered m-b-none"  width="100%">
							<thead>
								<tr>
				        <th class="text-center">
							id
						</th>
						<th class="text-center">
							Serveur
						</th>
                        <th class="text-center">
                            Disques            
                        </th>
						<th class="text-center">
				            Login
						</th>
                        <th class="text-center">
							Mot de passe
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
        <div class="tab-pane" id="tasks">
				<section class="panel">
					<header class="panel-heading">
                        Taches
					</header>
					
						<table id="taskstable" class="text-center table table-striped table-bordered m-b-none"  width="100%">
							<thead>
				<tr>
				        <th class="text-center">
							id
						</th>
						<th class="text-center">
							id demande
						</th>
						<th class="text-center">
				            Type
						</th>
                        <th class="text-center">
							Etat
						</th>
                       <th class="text-center">
							Output
						<th class="text-center">
                        Dernière Modification
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
			<div class="tab-pane <?= $adminactive ?>" id="adminrequest">
				<section class="panel">
					<header class="panel-heading form-inline">
						Demandes Utilisateurs
              <br/>             
            Type:
            <select id="type_dem_admin" style="width:135px;margin-left:5px;" class="form-control">
      <option value='c' selected>création</option>
      <option value='m' >Modification</option>
    <option value='s' >Suppression</option>
    </select>
            <br/>
					</header>
					
						<table class="text-center table table-striped table-bordered m-b-none" id="adminrequesttable" width="100%">
							<thead>
								<tr>
                                    <th class="text-center">id</th>
                                    <th class="">
                                        type
                                    </th>
									<th class="text-center">
										Demandeur
									</th>
									<th class="text-center">
										Nom Partage
									</th>
									<th class="text-center">
										Serveur
									</th>
									<th class="text-center">
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
									<th class="text-center" width="10%">
										Action
									</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					
				</section>
			</div>