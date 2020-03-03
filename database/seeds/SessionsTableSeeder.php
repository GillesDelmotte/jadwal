<?php

use App\Session;
use Illuminate\Database\Seeder;

class SessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Session::create([
            'user_id' => 1,
            'title' => 'Session Juin 2019',
            'content' => 'Bonjour à tous,

            Ceci concerne l’élaboration de la session d’examens de septembre 2019.

            Si vous m’avez envoyé les modalités de vos examens, vous pouvez oublier ce mail.

            Sinon, pouvez-vous SVP compléter et me renvoyer le document en pièce jointe pour le 30 avril au plus tard.

            Rappel : les examens des cours de B1 et uniquement ceux-là doivent être replanifiés en juin et septembre.

            Puis-je vous demander svp de :

            · Dans ce fichier, écrire votre nom (emplacement ad-hoc)

            · Utiliser l’intitulé EXACT des cours c’est-à-dire celui utilisé dans l’horaire de cours (sinon je ne m’y retrouve pas)

            · Donner la liste COMPLÈTE des groupes concernés et indiquer clairement les regroupements si nécessaire

            · Compléter le fichier plutôt que de répondre dans le corps du message

            Merci de comprendre qu’autant que possible vos demandes seront satisfaites mais à l’impossible nul n’est tenu ;- )

            Grand merci pour votre collaboration.',
            'date' => '2019-06-24 00:00:00',
        ]);

        Session::create([
            'user_id' => 1,
            'title' => 'Session Septembre 2019',
            'content' => 'Bonjour à tous,

            Ceci concerne l’élaboration de la session d’examens de septembre 2019.

            Si vous m’avez envoyé les modalités de vos examens, vous pouvez oublier ce mail.

            Sinon, pouvez-vous SVP compléter et me renvoyer le document en pièce jointe pour le 30 avril au plus tard.

            Rappel : les examens des cours de B1 et uniquement ceux-là doivent être replanifiés en juin et septembre.

            Puis-je vous demander svp de :

            · Dans ce fichier, écrire votre nom (emplacement ad-hoc)

            · Utiliser l’intitulé EXACT des cours c’est-à-dire celui utilisé dans l’horaire de cours (sinon je ne m’y retrouve pas)

            · Donner la liste COMPLÈTE des groupes concernés et indiquer clairement les regroupements si nécessaire

            · Compléter le fichier plutôt que de répondre dans le corps du message

            Merci de comprendre qu’autant que possible vos demandes seront satisfaites mais à l’impossible nul n’est tenu ;- )

            Grand merci pour votre collaboration.',
            'date' => '2019-09-19 00:00:00',
        ]);
    }
}
