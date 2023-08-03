<?php
$servername = "localhost";
$username = "postgres"; // FAVOR COLOCAR O USUÁRIO QUE VC CONFIGUROU SEU BANCO
$password = "123"; // FAVOR COLOCAR A SENHA QUE VC CONFIGUROU SEU BANCO
$dbname = "team_malhas";

try {
    $conn = new PDO("pgsql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $queryCheckDB = "SELECT 1 FROM pg_database WHERE datname = :dbname";
    $stmt = $conn->prepare($queryCheckDB);
    $stmt->bindParam(':dbname', $dbname);
    $stmt->execute();
    $databaseExists = $stmt->fetch();


    if (!$databaseExists) {
        $queryCreateDB = "CREATE DATABASE $dbname";
        $conn->exec($queryCreateDB);
        $conn->exec("SET TIME ZONE 'America/Sao_Paulo'");
    }

    $conn = null;

    $conn = new PDO("pgsql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET TIME ZONE 'America/Sao_Paulo'");
    $queryCheckTable = "SELECT EXISTS (SELECT FROM information_schema.tables WHERE table_name = 'products')";
    $stmt = $conn->query($queryCheckTable);
    $tableExists = $stmt->fetchColumn();

    if (!$tableExists) {
        $query = "CREATE TABLE products (
            id SERIAL PRIMARY KEY,
            product VARCHAR(30) NOT NULL,
            type_product VARCHAR(30) NOT NULL,
            description TEXT,
            name VARCHAR(100) NOT NULL,
            price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
            tax DECIMAL(10, 2) NOT NULL DEFAULT 0.00
        );";

        $conn->exec($query);
    }

    $queryCheckTable = "SELECT EXISTS (SELECT FROM information_schema.tables WHERE table_name = 'sales')";
    $stmt = $conn->query($queryCheckTable);
    $tableExists = $stmt->fetchColumn();

    if (!$tableExists) {
        $query = "CREATE TABLE sales (
            id SERIAL PRIMARY KEY,
            product_id INT NOT NULL,
            quantity INT NOT NULL,
            total DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
            date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        );";

        $conn->exec($query);

        $queryAddForeignKey = "ALTER TABLE sales ADD CONSTRAINT fk_product_id FOREIGN KEY (product_id) REFERENCES products(id)";
        $conn->exec($queryAddForeignKey);
    }

    $queryCheckTable = "SELECT EXISTS (SELECT FROM information_schema.tables WHERE table_name = 'dashboards')";
    $stmt = $conn->query($queryCheckTable);
    $tableExists = $stmt->fetchColumn();

    if (!$tableExists) {
        $query = "CREATE TABLE dashboards (
            id SERIAL PRIMARY KEY,
            goal_of_day DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
            date_updated TIMESTAMP NOT NULL
        );";

        $conn->exec($query);

        $query = "INSERT INTO dashboards (goal_of_day, date_updated) VALUES (0.00, NOW())";
        $conn->exec($query);
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
