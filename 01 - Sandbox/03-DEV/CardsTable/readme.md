# Documentation du Composant DataCards

Cette documentation fournit un aperçu de la structure du composant `DataCards` et de ses considérations en matière d'accessibilité.

## Vue d'ensemble

Le composant `DataCards` est conçu pour afficher des contenus sous forme de cartes, spécifiquement pour présenter des entrées de données. Chaque carte est regroupée dans une section logique qui peut être sélectionnée, dépliée et avec laquelle l'utilisateur peut interagir.

## Structure HTML

Le conteneur principal du composant `DataCards` est un élément `section`, avec un en-tête défini par un élément `h2`. À l'intérieur de cette section, chaque carte de données est représentée par une `div` avec la classe `rcn-card`. Cette `div` se voit attribuer un `role="group"` pour indiquer qu'elle contient un ensemble groupé d'éléments connexes.

### Titre de la Carte et Sélection

Le titre de la carte et la case à cocher de sélection sont enveloppés dans une `div` avec les classes `rcn-card__contentZone` et `rcn-card__contentZone--titleCardTable`.

- Une entrée `checkbox` permet aux utilisateurs de sélectionner la carte. Elle est munie d'un `aria-label` pour que les lecteurs d'écran annoncent son but.
- Un label visuellement caché (`sr-only`) est associé à la case à cocher, fournissant un contexte supplémentaire pour les utilisateurs de lecteurs d'écran.
- L'élément `h2` avec la classe `rcn-h4 rcn-card__title` sert de titre à la carte. Il est lié à la case à cocher via l'attribut `id` utilisé dans `aria-labelledby`.

### Description de la Carte

Sous le titre, une `div` avec la classe `rcn-card__content` comprend un paragraphe (`p`) pour la description et un bouton pour étendre et montrer plus de détails. Le bouton contrôle la visibilité de la description complète et utilise `aria-controls` et `aria-expanded` pour communiquer son état et l'élément qu'il affecte.

### Informations sur la Date de la Carte

La carte affiche également des informations de date dans une `div` avec la classe `rcn-card__dateInfo`, fournissant les dates de réception et d'échéance pour l'entrée de données.
