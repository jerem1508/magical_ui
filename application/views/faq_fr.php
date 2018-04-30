
<img src="<?php echo base_url('assets/img/poudre.png');?>" class="poudre poudre_pos_home">

<style type="text/css">
	h3{
		color: #777;
		/*text-transform: uppercase;*/
	}
	h3::first-letter{
		color: #E00612;
		font-size: 1.5em;
		font-weight: bold;
	}
</style>

<div class="container-fluid">
	<div class="well text-justify">
		<div class="row text-center">
			<h1 style="color: #25358C">Foire Aux Questions</h1>
		</div>

        <h2>La Machine à données, comment la Faire marcher ?</h2>

        <h3>Qu’est-ce que ça fait ?</h3>
        Cet outil permet de faire des jointures entre deux fichiers de données tabulaires (csv, Excel). Malheureusement, il n'y a rien de magique; plus les données d'entrées sont propres et proches, plus la jointure sera performante. Pour schématiser, si un humain sans connaissance métier est capable de distinguer deux lignes de match et de lignes de non-match dans vos fichiers d'entrée, alors la machine pourra peut-être joindre vos fichiers; sinon, elle n'aura sans doute pas de succès.

        <h3>Prérequis</h3>
        <ul>
            <li>Il est attendu que les entités du ficher sale soient un sous-ensemble de celles du fichier de référence (c’est-à-dire qu'on doit pouvoir être capable de retrouver la plupart des lignes de la source dans la référence).</li>
            <li>Les lignes à apparier dans la source et la référence doivent avoir des mots en commun (à quelques fautes d'orthographe près). Le matching s'appuie sur le texte et cherche des similarités entre les chaînes de caractères.</li>
            <li>Aucun savoir sémantique n'est requis. La machine n'a pas de connaissances de type humain et ne sait pas, par exemple, que "Chateau" et "Forteresse" ont un sens proche qui pourrait aider à matcher. Cela étant dit, il y a quelques cas où nous avons inclus un savoir sémantique (par la fonction `synonym` de Elasticsearch). Pour les villes il est possible de trouver « Paris » en recherchant « Lutèce ». En ajustant le code, il est possible d'ajouter vos propres banques de synonymes pour créer de telles équivalences.</li>
            <li>Aucun savoir extérieur n'est requis. La machine fera les matchs en s'appuyant uniquement sur les données présentes dans la ligne. Elle n'ira pas chercher de données d'une source externe (sauf dans le cas de synonymes, décrits ci-dessus).</li>
        </ul>

        <h3>Concepts</h3>
        <ul>
            <li>« source »: Une table de données sales à laquelle on souhaite joindre une référence</li>
            <li>« ref » (référentiel) : Une table de données propres dans laquelle nous recherchons des éléments de la source.</li>
        </ul>
        <hr />
        <h2>1. Données d'entrée</h2>
        Les entrées sont un fichier source et un fichier de référence.

        <h3>Dois-je nettoyer les données d'entrée ?</h3>
        Ça dépend ... Nous suggérons d'essayer le matching sans pré-processing. Mais il faut garder en tête que plus les données d'entrée sont propres et proches, plus le matching sera performant. Si les résultats ne sont pas satisfaisants, nous suggérons d'essayer ce qui suit:
        <ul>
            <li>Enlever les mots « parasites » qui ne présents que dans un des deux fichiers.</li>
            <li>Créer des colonnes avec des variables catégorielles pour faciliter la distinction.</li>
            <li>Utiliser un géocodeur pour normaliser les variables d'adresse.</li>
            <li>Normaliser les codes (identifiants, numéros de téléphone, ...)</li>
            <li>Généralement: essayer de rendre la source plus proche du référentiel</li>
        </ul>
        <hr />
        <h2>2. Appariement de colonnes</h2>
        L'appariement de colonne décrit les colonnes qui partagent des informations qui peuvent servir au matching. Il est possible de spécifier plusieurs colonnes à matcher. Par exemple, on apparie en utilisant simultanément un champ « NOM_ETABLISSEMENT  et un champ « VILLE ». Par ailleurs, l'appariement de colonnes n'est pas nécessairement 1 à 1 mais peut aussi impliquer plusieurs colonnes de la source ou du référentiel; les différents comportements sont décrits ci-dessous:

        <h3>Ajout de paires multiples</h3>
        Les appariements sont des indications pour l'algorithme d'apprentissage. L'algorithme va probablement sélectionner un sous-ensemble des paires indiquées pour le matching. Les paires sélectionnées agiront comme un "ET". Ajouter autant de paires que possible pour couvrir toutes les possibilités peut être tentant (peut-être, par exemple,que matcher e-mail et pays peut être utile). Mais cela risque de rendre les calculs plus lents et lourds pour notre serveur et risque aussi d'ajouter du bruit qui peut nuire à l'apprentissage. L'appariement idéal est généralement l'ensemble minimal de colonnes qui permettrait à un humain de décider si une paire de lignes est un match ou non.

        <h3>Colonnes multiples pour la source dans l'appariement</h3>
        Quand plusieurs colonnes sont sélectionnées pour la source, les valeurs de celles-ci seront concaténées (avec un espace) et le résultat sera recherché comme un tout dans le référentiel. Cela peut être utile quand deux champs de la source correspondent à un champ du référentiel, mais aussi quand les données à matcher se trouvent alternativement dans un champ ou dans l'autre de la source.

        <h3>Colonnes multiples pour la référence dans l'appariement</h3>
        Quand plusieurs colonnes sont sélectionnées pour la référence, les valeurs de la source seront recherchées dans ces deux colonnes et des résultats seront renvoyés s'il y a un match dans l'une ou dans l'autre des colonnes (agissant comme un "OU").
        <hr />
        <h2>3. Labellisation / Apprentissage</h2>
        Dans la labellisation, l'utilisateur doit informer la machine si des paires de lignes (une de la source, une du référentiel) sont censées correspondre. La labellisation peut être utilisée pour deux utilisations :
        <ul>
            <li>Pour apprendre les paramètres optimaux pour effectuer une jointure automatique</li>
            <li>Pour manuellement apparier un fichier entièrement (ce qui peut être beaucoup plus rapide que le "CTRL+F CTRL+C CTRL+V" dans Excel, par exemple).</li>
        </ul>

        <h3>Réponses possibles</h3>
        <ul>
            <li>Oui : la paire montrée est un match ;</li>
            <li>Non: la paire montrée n'est pas un match ;</li>
            <li>Incertain: je ne sais pas si la paire montrée est un match ;</li>
            <li>Oublier: cette ligne de la source ne devrait pas être matchée,  ne pas la prendre en compte (par exemple dans le cas où l’utilisateur sait qu’aucune entrée du référentiel n’est adaptée à cette valeur de la source).</li>
        </ul>

        <h3>Termes obligatoires / à exclure</h3>
        Ces filtres permettent de restreindre le fichier de référence pour le matching. Les termes obligatoires agissent comme des « ET », c'est-à-dire que les lignes proposées après le filtrage devront obligatoirement contenir toutes les informations dans les filtres. Les termes à exclure agissent comme des « OU », c'est à dire que les lignes proposées ne contiendront aucun des termes à exclure. Ces filtres peuvent être utiles pour augmenter la précision du matching sur une base beaucoup plus large que ce que l'on recherche. Par exemple, si l'on cherche des lycées dans la base SIRENE, on ajoutera le terme obligatoire « lycee » au champ « NOMEN_LONG » ; on pourra aussi exclure le mot « parents » pour ne pas avoir dans les résultats "association de parents du lycée abc", par exemple.

        <h3>Recherche mot par mot. Comment et pourquoi ?</h3>
        Il est possible de rechercher des termes de la source mot à mot en cliquant dessus. Cette recherche annule temporairement les résultats générés par le labellisateur. Cette fonctionnalité peut être utile pour trouver un match plus rapidement qu’en attendant que le labellisateur le propose. Par ailleurs, si l’on constate qu’il n’y a pas de résultat par la recherche mot à mot et que ce mot, cela indique que les mots recherchés ne sont pas présents dans le référentiel; on peut alors « oublier » la ligne de la source.

        <hr />
        <h2>4. Résultats</h2>
        <h3>Comment les lire ?</h3>
        On affiche les lignes dans l'ordre du fichier source. Pour chaque ligne on montre les éléments de la source (pour les colonnes qui servent au match) ainsi que les éléments de la ligne de la référence qui sont proposées comme match. Le score indique la confiance de la machine dans le match et le bouton Vrai/Faux indique si la machine pense que la ligne montrée est effectivement un match (en fonction du score).

        <h3>Score et seuil</h3>
        Les résultats sont renvoyés avec un score correspondant au score Elasticsearch. Le seuil détermine le score à partir duquel la machine estime qu'une paire de lignes est un match

        <h3>Vrai / Faux</h3>
        Les boutons indiquent par défaut si la machine suppose que la paire montrée est un match (quand la machine ne trouve pas de match, elle peut renvoyer ce qu'elle considère comme le meilleur candidat). L'utilisateur peut modifier la valeur Vrai/Faux pour indiquer qu'une paire est effectivement un match (Vrai) ou non (Faux). Cela se retrouvera lors du téléchargement du fichier.

        <h3>Le fichier de sortie</h3>
        Le fichier de sortie présente autant de lignes que votre fichier source. Toutes les colonnes du fichier source sont présentes. Par ailleurs, les colonnes du référentiel sont aussi présentes sous leur nom original suivi du suffixe “__REF” (par exemple: « adresse_REF »). Pour chaque ligne, lorsqu’un match a été trouvé, les valeurs correspondantes du référentiel se trouvent dans ces colonnes. Par ailleurs nous créons les colonnes suivantes :
        <ul>
            <li>__CONFIDENCE : La confiance que nous accordons au match présenté. Dans notre machine, les résultats avec une confiance au-dessus de 1 sont considérés comme des matchs. Les lignes pour lesquelles la confiance vaut 999 correspondent à des lignes labellisées comme étant des matchs par l’utilisateur.</li>
            <li>__IS_MATCH : Vaut 1 si la machine pense que la paire présentée est une match valide. Si elle vaut 0, c’est que c’est que les valeurs trouvées pour la référence sont les meilleurs à proposer mais que la machine ne pense pas que le match est valide.</li>
            <li>__ID_REF : Identifiant interne associé à la ligne de la référence. Peut être utile pour des jointures croisées de 2 fichiers sales.</li>
            <li>__ID_QUERY: L’identifiant de la méthode utilisée pour le match (spécifique à chaque projet de jointure). Peut être utile pour faire des distinctions de cas si vous observez des performances fluctuantes selon cette variable.</li>
            <li>__ES_SCORE : Le score original de la requête Elasticsearch avec la méthode (__ID_QUERY) choisie pour la ligne en question.</li>
            <li>__THRESH : Le seuil (relatif au score __ES_SCORE) pour la méthode (__ID_QUERY) utilisé pour la machine pour déterminer la confiance (__CONFIDENCE) et si le match est valide (__IS_MATCH)</li>
        </ul>
        <hr />
        <h2>5. Bonne conduite</h2>
        Le service en est à ses débuts et est encore fragile (il tourne sur une petite machine).  Il faut en prendre soin ! Il y a actuellement assez peu de limitations, mais nous vous demandons cependant d'être raisonnables pour que ce service continue à fonctionner au mieux. En particulier :
        <ul>
            <li>Utilisez en priorité les référentiels publics puis ceux que vous avez déjà uploadés.</li>
            <li>Ne ré-uploadez pas les mêmes projets plusieurs fois.</li>
            <li>Soyez raisonnables sur la taille des fichiers. L'indexation de référentiels comme le SIRENE (10M de lignes) prend plusieurs heures et est très coûteux en termes de RAM et CPU ce qui diminue les performances pour tous les autres utilisateurs.</li>
            <li>Si vous n'allez plus utiliser un projet, merci de le supprimer dans l'onglet projets de normalisation du tableau de bord.</li>
            <li>N'utilisez pas ce service comme stockage. Nous nous réservons le droit de supprimer les projets sans préavis.</li>
            <li>Ce service a pour but d’aider à la jointure pour des cas complexes (fuzzy match). N’utilisez pas ce service s’il s’agit de faire de simples jointures de bases si vous disposez des ressources pour le faire.</li>
            <li>Soyez patients. Si ça tourne et qu'il n'y a pas eu de message d'erreur, c'est (généralement) que ça avance. Rafraîchir la page relancera l'appel API et prendra autant de temps en plus.</li>
            <li>Contactez-nous pour rapporter des bugs ou des suggestions !</li>
        </ul>
	</div>
</div>
