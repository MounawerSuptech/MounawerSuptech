<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219124730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etudiant_module (etudiant_id INT NOT NULL, module_id INT NOT NULL, INDEX IDX_185A404BDDEAB1A3 (etudiant_id), INDEX IDX_185A404BAFC2B591 (module_id), PRIMARY KEY(etudiant_id, module_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etudiant_module ADD CONSTRAINT FK_185A404BDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_module ADD CONSTRAINT FK_185A404BAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe ADD department_id INT NOT NULL');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('CREATE INDEX IDX_8F87BF96AE80F5DF ON classe (department_id)');
        $this->addSql('ALTER TABLE etudiant ADD classe_id INT NOT NULL, ADD relation VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E38F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('CREATE INDEX IDX_717E22E38F5EA509 ON etudiant (classe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant_module DROP FOREIGN KEY FK_185A404BDDEAB1A3');
        $this->addSql('ALTER TABLE etudiant_module DROP FOREIGN KEY FK_185A404BAFC2B591');
        $this->addSql('DROP TABLE etudiant_module');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96AE80F5DF');
        $this->addSql('DROP INDEX IDX_8F87BF96AE80F5DF ON classe');
        $this->addSql('ALTER TABLE classe DROP department_id');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E38F5EA509');
        $this->addSql('DROP INDEX IDX_717E22E38F5EA509 ON etudiant');
        $this->addSql('ALTER TABLE etudiant DROP classe_id, DROP relation');
    }
}
