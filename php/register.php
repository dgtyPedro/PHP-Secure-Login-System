<?php
require_once 'config.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $name)){
    #Nome não existente
    ?>
    <script>
    javascript:alert('Seu nome tem caracteres invalidos!');
    javascript:window.location='../register.html';
    </script>
    <?php
    
}else{

    if (strlen($password)>=8){
        //Todas etapas feitas

        //Verificar se a conta ja existe
        if ($stmt = $conn->prepare('SELECT id password FROM users WHERE email = ?')) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();
            
            
            if ($stmt->num_rows == 0) {

                //nao existe esse record, pode gravar
                $stmt->close();
                $hash = password_hash($password, PASSWORD_BCRYPT);
                $stmt = $conn->prepare("INSERT INTO users (name, password, email) values (?, ?, ?)");
                $stmt->bind_param('sss', $name, $hash, $email);
                $stmt->execute();
                $stmt->close();
                ?>
                <script>
                javascript:alert('Conta criada com sucesso!');
                javascript:window.location='../login.html';
                </script>
                <?php
                
            } else {
                //existe o record
                $stmt->close();
                ?>
                <script>
                javascript:alert('Ja existe esse usuario!');
                javascript:window.location='../register.html';
                </script>
                <?php
            }
        }

   }else{
        #Senha fraca
        ?>
        <script>
        javascript:alert('Ja existe esse usuario!');
        javascript:window.location='../register.html';
        </script>
        <?php
   }

}