
# Atlantis - Loads management system

Atlantis este o aplicație web robustă dezvoltată pentru gestionarea eficientă a operațiunilor logistice. Proiectată pentru companii de transport și logistică, aceasta oferă o soluție completă pentru managementul încărcăturilor, clienților, și transportatorilor.

## Features

- Dashboard Interactiv: Oferă o privire de ansamblu asupra operațiunilor curente, inclusiv statistici despre încărcături și clienți.
- Managementul Încărcăturilor: Permite crearea, editarea și urmărirea încărcăturilor în timp real.
- Gestionarea Clienților și Transportatorilor: Sistem integrat pentru administrarea informațiilor despre clienți și transportatori.
- Sistem de Roluri și Permisiuni: Suportă multiple roluri de utilizatori (admin, operațiuni, vânzări, serviciu clienți) cu permisiuni specifice.

## Tech Stack

- **Backend**: Laravel (PHP)
- **Frontend**: Blade Templates, TailwindCSS
- **Bază de Date**: MySQL
- **Autentificare**: Laravel built-in authentication

## Installation

Clonați repository-ul:

```bash
git clone https://github.com/PavelS05/SI.git
```

Instalați dependințele:

```bash
composer install npm install && npm run dev
```

Copiați fișierul *.env.example* în *.env* și configurați variabilele de mediu, inclusiv conexiunea la baza de date. 

Generați cheia aplicației:

```bash
php artisan key:generate
```

Rulați migrările pentru a crea structura bazei de date: 

```bash
php artisan migrate
```

(Optional) Populați baza de date cu date de test:

```bash
php artisan db:seed
```


## Usage
După instalare, puteți accesa aplicația prin browser-ul web. Utilizați credențialele de administrator pentru a vă autentifica și a începe configurarea sistemului.
## Contributing

Contribuțiile sunt binevenite! Vă rugăm să citiți `CONTRIBUTING.md` pentru detalii despre procesul nostru de trimitere a pull request-urilor.
## License

[MIT](https://github.com/PavelS05/SI/blob/main/LICENSE)


## Contact

Pentru întrebări sau suport, vă rugăm să deschideți un issue în repository-ul GitHub sau să contactați echipa de dezvoltare la pavel.sclifos.05@gmail.com.