# Commandes PSQL pour créer des comptes

Voici les commandes SQL à exécuter directement dans `psql` (ou pgAdmin) pour créer manuellement un compte **Apprenant** et un compte **Formateur** dans la base de données.

⚠️ **Information importante** : Dans Laravel, les mots de passe sont hachés. Le hash utilisé ci-dessous (`$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi`) correspond au mot de passe : `password`.

---

## 1. Créer un compte Apprenant

Cette requête utilise une clause `WITH` (CTE) pour insérer l'utilisateur dans la table `comptes`, récupérer son nouvel `id`, et l'insérer directement dans la table de liaison `compte_role` avec le rôle "apprenant".

```sql
WITH nouvel_apprenant AS (
    INSERT INTO comptes (prenom, nom, email, telephone, mot_de_passe, created_at, updated_at)
    VALUES (
        'Lucas', 
        'Apprenant', 
        'lucas@example.com', 
        '0611223344', 
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- Mot de passe : password
        NOW(), 
        NOW()
    )
    RETURNING id
)
INSERT INTO compte_role (compte_id, role_id)
SELECT nouvel_apprenant.id, roles.id
FROM nouvel_apprenant, roles
WHERE roles.code = 'apprenant';
```

---

## 2. Créer un compte Formateur

Même principe, mais nous associons ce compte au rôle "formateur".

```sql
WITH nouveau_formateur AS (
    INSERT INTO comptes (prenom, nom, email, telephone, mot_de_passe, created_at, updated_at)
    VALUES (
        'Sophie', 
        'Formatrice', 
        'sophie@example.com', 
        '0699887766', 
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- Mot de passe : password
        NOW(), 
        NOW()
    )
    RETURNING id
)
INSERT INTO compte_role (compte_id, role_id)
SELECT nouveau_formateur.id, roles.id
FROM nouveau_formateur, roles
WHERE roles.code = 'formateur';
```

---

## 💡 Comment exécuter cela ?

1. Ouvrez votre terminal (ou invite de commandes).
2. Connectez-vous à votre base de données via psql :
   ```bash
   psql -U postgres -d plateforme_formation_steph
   ```
3. Copiez l'un des blocs SQL ci-dessus, collez-le dans le terminal et appuyez sur **Entrée**.
