
<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<style type="text/css">
	h3{
		color: #777;
	}
    hr{
        border-top: dashed 4px #ccc;
    }
</style>

<div class="container-fluid">
	<div class="well">
        <div class="container">

            <h2>Comment utiliser la machine à données ?</h2>
            <h3>Les fichiers de ce tutoriel :</h3>
            <ul>
                <li>
                    La source contient des informations associées à des lycées :
                    <a href="<?php echo base_url('assets/tutorial/source_tuto.csv');?>">source_tuto.csv</a>
                </li>
                <li>
                    La référence est une base de lycées avec leur identifiant unique UAI:
                    <a href="<?php echo base_url('assets/tutorial/ref_tuto.csv');?>">ref_tuto.csv</a>
                </li>
            </ul>

            <hr>
            <h3>Upload des deux fichiers et création du projet :</h3>
            <img src="<?php echo base_url('assets/tutorial/tuto_upload.gif');?>" alt="" class="img-responsive">

            <hr>
            <h3>Sélection des colonnes :</h3>
            Vérifier que le fichier a été correctement uploadé
            <img src="<?php echo base_url('assets/tutorial/tuto_visualization_upload.gif');?>" alt="" class="img-responsive">

            <hr>
            <h3>Inférence de types des colonnes :</h3>
            Elle est optionnelle et peut être passée. Il est possible de corriger les types détectés par la machine.
            <img src="<?php echo base_url('assets/tutorial/tuto_inference_types.gif');?>" alt="" class="img-responsive">

            <hr>
            <h3>Appariement de colonnes :</h3>
            Il faut grouper ensemble les colonnes censées correspondre. Dans le cas de ce fichier, il est intéressant de grouper les colonnes:
            <ul>
                <li>departement avec departement</li>
                <li>commune avec localite_acheminement_uai</li>
                <li>lycees_sources avec denomination_principale_uai et patronyme_uai</li>
            </ul>
            <img src="<?php echo base_url('assets/tutorial/tuto_association_de_colonnes.gif');?>" alt="" class="img-responsive">

            <hr>
            <h3>Labellisation :</h3>
            Il faut indiquer à la machine les paires qui sont ou ne sont pas des matchs pour qu’elle affine l’algo de matching en cliquant sur “oui” ou “non”. On peut utiliser le bouton “précédent“ pour revenir en arrière. On peut utiliser je ne sais pas quand le cas est ambigu.
            <img src="<?php echo base_url('assets/tutorial/tuto_labelling_2.gif');?>" alt="" class="img-responsive">
            <img src="<?php echo base_url('assets/tutorial/tuto_labelling_4.gif');?>" alt="" class="img-responsive">

            On peut accélérer la labellisation (au début notamment), en indiquant directement les mots qui importants en cliquant dessus (tous les mots sélectionnés seront recherchés dans la table de référence).
            <img src="<?php echo base_url('assets/tutorial/tuto_labelling_1.gif');?>" alt="" class="img-responsive">

            Quand les performances semblent satisfaisantes (après au moins 5 labellisations), on peut passer à l’étape suivante.
            <img src="<?php echo base_url('assets/tutorial/tuto_labelling_5.gif');?>" alt="" class="img-responsive">

            <hr>
            <h3>Résultats :</h3>
            On voit pour chaque ligne de la source la correspondance dans le référentiel qui a été trouvée par la machine (ou non). Le bouton vrai/faux permet d’indiquer si le match trouvé est effectivement bon. Certains matchs sont déjà à “faux” car la machine n’a pas une confiance suffisante dans le match proposés. Les matchs à “faux” ne seront pas présents dans le fichier final.
            <img src="<?php echo base_url('assets/tutorial/tuto_resultats_1.gif');?>" alt="" class="img-responsive">

            On peut trier les résultats par confiance. Si les résultats ne sont pas satisfaisants on peut revenir à la labellisation ou même changer l’appariement de colonnes. Sinon, on peut télécharger le fichier avec les résultats du matching.
            <img src="<?php echo base_url('assets/tutorial/tuto_resultats_2.gif');?>" alt="" class="img-responsive">

        </div><!-- / container -->



	</div>
</div>
