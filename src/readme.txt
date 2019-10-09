



Connexion :

URL: /gettoken (POST)

On se connecte en effectuant une requête de type POST contenant les paramètres login et pass en json dans le corps "Body" de la requête.

Puis on récupère le token si login et pass existe

---

(suite doc pour dev)

l'api verifie si login et pass sont existant dans "login_secret_key",

si existant ça récupère le droit et le telhab de l'utilisateur.

Par defaut si c'est un dev consortium qui se connecte alors le telhab sera 'devconsortium' et son droit (full) à 1 dans la table "login_secret_key",

sinon c'est le droit = 0 et le telhab du client concerné.

Puis on créer le token avec le telhab encodé, le telhab normal et le timestamp du moment.

Le token est ensuite enregitré dans login_token_tmp, et envoyé en reponse.






