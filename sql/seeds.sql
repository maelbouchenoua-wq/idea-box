/*
                            ---prompt---
je suis en train de développer une petit application (boite à idée) je m'occupe actuellement de la base de donnée. voici la table :

CREATE TABLE IF NOT EXISTS info (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100) NOT NULL,
  description TEXT NOT NULL,
  pseudo VARCHAR(50) NOT NULL,
  createDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  nbVote INT NOT NULL DEFAULT 0
) ENGINE = InnoDB;

insert moi dans la table 20 valeur.
je veux des accent, texte long, accent et des vote variés. il ne faut pas de vrais nom / email
 */


INSERT INTO info (title, description, pseudo, createDate, nbVote) VALUES
('Café gratuit le vendredi',
'Proposer du café et du thé gratuits chaque vendredi matin dans la salle commune. Cela favoriserait les échanges entre les équipes et améliorerait l''ambiance générale avant le week-end.',
'CaféLover42', '2026-09-02 08:15:00', 87),

('Salle de détente',
'Aménager une petite salle de détente avec des fauteuils confortables, quelques jeux de société et une machine à café. Un espace pour se ressourcer pendant la pause déjeuner, loin des écrans et du bruit de l''open space.',
'RenardMalin', '2026-09-03 10:42:00', 142),

('Télétravail deux jours par semaine',
'Autoriser le télétravail deux jours par semaine pour tous les postes compatibles. Cela réduirait les temps de transport, améliorerait l''équilibre vie professionnelle / vie personnelle et permettrait de mieux se concentrer sur les tâches complexes. Un bilan pourrait être fait après trois mois pour ajuster le dispositif.',
'NuageGris', '2026-09-05 14:20:00', 187),

('Mode sombre',
'Ajouter un mode sombre à l''application, car il est beaucoup plus agréable pour les yeux en soirée.',
'ChouetteNoctambule', '2026-09-07 21:05:00', 64),

('Vélos en libre-service',
'Mettre à disposition quelques vélos électriques pour les déplacements entre les différents bâtiments et les rendez-vous en ville. Écologique, économique et plutôt sympathique !',
'PédaleDouce', '2026-09-09 09:30:00', 53),

('Tournoi de baby-foot',
'Organiser un tournoi de baby-foot mensuel avec un classement affiché dans le hall d''entrée. Les gagnants pourraient remporter un déjeuner offert ou le droit de choisir la musique du vendredi.',
'GardienDeBut', '2026-09-12 16:45:00', 31),

('Formation premiers secours',
'Prévoir une session de formation aux premiers secours (PSC1) ouverte à tous les volontaires. Savoir réagir en cas de malaise ou d''accident est une compétence essentielle, et elle serait utile bien au-delà du cadre professionnel.',
'SecouristeZen', '2026-09-15 11:10:00', 96),

('Plus de plantes vertes',
'Végétaliser les bureaux : des plantes vertes dans les couloirs, sur les bureaux et près des fenêtres. Elles purifient l''air, apaisent le regard et rendent les lieux nettement plus accueillants.',
'PouceVert', '2026-09-18 13:55:00', 45),

('Menu végétarien à la cantine',
'Proposer au moins une option végétarienne complète et savoureuse chaque jour à la cantine. Beaucoup de personnes en font la demande, et cela permettrait de diversifier l''offre tout en réduisant l''impact environnemental des repas servis.',
'CarotteRâpée', '2026-09-22 12:05:00', 118),

('Boîte à lecture',
'Installer une boîte à lecture dans le hall pour échanger des livres, des BD et des magazines.',
'Bouquineur', '2026-09-25 17:30:00', 12),

('Horaires flexibles',
'Mettre en place des horaires flexibles avec des plages de présence obligatoires entre 10 h et 16 h. Chacun pourrait adapter son rythme selon ses contraintes personnelles (enfants, transports, rendez-vous médicaux), ce qui améliorerait la motivation et réduirait le stress du matin.',
'OiseauMatinal', '2026-10-01 07:50:00', 152),

('Rénovation du parking à vélos',
'Le parking à vélos actuel est trop petit et mal éclairé. Il faudrait l''agrandir, ajouter un toit et installer des prises pour recharger les vélos électriques.',
'Cycliste_75', '2026-10-04 08:40:00', 38),

('Journée solidaire annuelle',
'Dédier une journée par an à une action solidaire : nettoyage d''un parc, collecte alimentaire, aide à une association locale. Un excellent moyen de renforcer la cohésion d''équipe tout en faisant du bien autour de nous.',
'CœurGénéreux', '2026-10-08 15:15:00', 74),

('Salle de sport',
'Créer une petite salle de sport équipée de tapis de yoga, d''haltères et de quelques machines de base. Les employés pourraient s''y entraîner avant ou après le travail, ce qui serait bénéfique pour la santé et la bonne humeur de tout le monde.',
'MuscleDeCoton', '2026-10-11 18:00:00', 69),

('Application mobile dédiée',
'Développer une version mobile de la boîte à idées pour pouvoir voter et proposer des suggestions depuis son téléphone, même en déplacement.',
'PixelCurieux', '2026-10-14 19:25:00', 101),

('Ateliers de découverte numérique',
'Organiser des ateliers pour apprendre à utiliser les outils collaboratifs, sécuriser ses mots de passe et reconnaître les tentatives d''hameçonnage. Des sessions courtes d''une heure, animées par des volontaires, avec des exemples concrets tirés du quotidien. Ça aiderait vraiment les personnes moins à l''aise avec l''informatique.',
'ClavierTimide', '2026-10-19 10:00:00', 58),

('Réduire les gobelets jetables',
'Remplacer les gobelets en plastique par des tasses réutilisables et offrir une écocup à chaque nouvel arrivant.',
'ÉcoloGourmand', '2026-10-27 09:12:00', 27),

('Soirée jeux vidéo',
'Organiser une soirée jeux vidéo conviviale une fois par trimestre, avec des jeux coopératifs et des snacks. Ouvert à tous les niveaux, même aux débutants complets !',
'ManetteEnFolie', '2026-11-05 20:10:00', 9),

('Boîte à compliments',
'Mettre en place une boîte où l''on peut déposer des petits mots de remerciement anonymes pour ses collègues. Un geste simple, gratuit, qui fait toujours plaisir et qui encourage la bienveillance au quotidien.',
'PapillonSolaire', '2026-11-12 11:35:00', 3),

('Wifi plus rapide dans la cafétéria',
'La connexion est très instable dans la cafétéria, ce qui rend les pauses déjeuner et les visioconférences improvisées compliquées. Ajouter une borne supplémentaire règlerait sûrement le problème.',
'ConnecteVite', '2026-11-20 12:50:00', 0);