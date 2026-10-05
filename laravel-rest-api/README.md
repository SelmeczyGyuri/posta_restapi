## API végpontok

| Metódus | URL                                                        | Leírás                                     | Hitelesítés |
|---------|------------------------------------------------------------|--------------------------------------------|-------------|
| POST    | /api/users/login                                           | Bejelentkezés, Sanctum tokent ad vissza    | Nem         |
| GET     | /api/users                                                 | Felhasználók lekérdezése                   | Igen        |
| GET     | /api/cities                                                | Városok listázása (lapozással)             | Nem         |
| GET     | /api/cities?search=...                                     | Városok keresése                           | Nem         |
| GET     | /api/cities?county=...                                     | Szűrés megyék szerint                      | Nem         |
| GET     | /api/cities?search=...&county=...&sort_by=...&sort_dir=... | Városok keresése, szűrése és rendezése     | Nem         |
| GET     | /api/cities/{id}                                           | Egy város adatai                           | Nem         |
| POST    | /api/cities                                                | Új város létrehozása                       | Igen        |
| PATCH   | /api/cities/{id}                                           | Város módosítása                           | Igen        |
| DELETE  | /api/cities/{id}                                           | Város törlése                              | Igen        |
| GET     | /api/counties                                              | Megyék listázása                           | Nem         |
| GET     | /api/counties?search=...                                   | Megyék keresése                            | Nem         |
| GET     | /api/counties?search=...&sort_by=...&sort_dir=...          | Megyék keresése rendezése                  | Nem         |
| GET     | /api/counties/{id}                                         | Egy megye adatai és városa(i)              | Nem         |
| GET     | /api/counties/{id}?sort_by=...&sort_dir=...                | Egy megye adatai és városa(i)              | Nem         |
| POST    | /api/counties                                              | Új megye létrehozása                       | Igen        |
| PATCH   | /api/counties/{id}                                         | Megye módosítása                           | Igen        |
| DELETE  | /api/counties/{id}                                         | Megye törlése                              | Igen        |