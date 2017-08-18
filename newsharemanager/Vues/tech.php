<div class="tab-pane <?= $techactive ?>" id="techshare">
				<section class="panel">
					<header class="panel-heading">
                        <div class="form-inline">
                                <label style="margin-right:7px">Matricule Uilisateur : </label>
                                <input type="text" name="matcollab" class="form-control" style="width:130px;margin-right:5px" required>
                                <button type="button" class="btn btn-primary btn-primary" onclick="refreshtech();"><span class="glyphicon glyphicon-wrench"></span></button>
                                
                            
                        </div>
					</header>
					<div class="table-responsive">
						<table class="text-center table table-striped table-bordered m-b-none" id="techsharetable" width="100%">
							<thead>
								<tr>
                                    <th class="" width="20%">id</th>    
						      <th class="text-center" width="20%"> @ Adresse Réseau </th>
						      <th class="text-center" width="10%">Serveur</th>
						      <th class="text-center" width="10%">Disque</th>
                              <th class="text-center" width="15%">Taille actuelle</th>
						      <th class="text-center" width="10%">Quota</th>
						      <th class="text-center" width="20%">Collaborateurs</th>
						      <th class="text-center" width="15%">Etat</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</section>
</div>