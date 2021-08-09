<?php
session_start();

include("../db/connection.php");
include("php/rows-query(registration).php");

include("modals/insert-data(registration).php");

include("modals/edit-data(registration).php");

include("modals/delete-data(registration).php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculdade CDL | Matrículas</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/tables.css">
    <link rel="stylesheet" href="css/modals.css">
</head>
<body>
    <header.>
        <div class="header">
        </div>
        <div class="underHeader">
            <ul>
                <li><a href="courses.php">Cursos</a></li>
                <li><a href="students.php">Alunos</a></li>
                <li><a href="registration.php">Matrículas</a></li>
                <?php
                    if (!isset($_SESSION["authenticated"])):
                ?>
                    <li class="userName"><a href="login.php">Login</a></li>
                    <li class="enter"><a href="signup.php">Cadastrar</a></li>
                <?php
                    endif;
                ?>
                <?php
                    if (isset($_SESSION["authenticated"])):
                ?>
                    <li class="userName"><a href="panel.php"><?php echo $_SESSION["user"];?></a></li>
                    <li class="logout"><a href="php/logout.php">Sair</a></li>
                <?php
                    endif;
                ?>
            </ul>
        </div>
    </header>
    <section>
        <aside>
            <div class="asideColumn">
            </div>
        </aside>
        <div class="sectionCard">
            <div class="table">
                <table class="t01">
                    <tr>
                        <th>Aluno</th>
                        <th>Curso</th>
                        <th>Editar</th>
                        <th><a href="?insert=" style="color: #ffffff;">Inserir</a></th>
                        <th>Deletar</th>
                    </tr>
                    <tr>
                    <?php
                        while ($rows = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $rows["user"]; ?></td>
                            <td><?php echo $rows["course_name"]; ?></td>
                            <td><a href="?edit=<?php echo $rows["student_course_id"]; ?>"><img src="icons/pencil-24.svg" alt="Edit button"></a></td>
                            <td><a href="?insert=<?php echo $rows["student_course_id"]; ?>"><img src="icons/clippy-24.svg" alt="Clippy button"></a></td>
                            <td><a href="?delete=<?php echo $rows["student_course_id"]; ?>"><img src="icons/trash-24.svg" alt="Trash button"></a></td>
                        </tr>
                    <?php
                        }
                    ?>
                </table>
<!------------------------------------------------Insert Modal------------------------------------------------>
                <div id="insertModal" class="modal">
                    <form action="" method="POST">
                        <div class="modalHeader">
                            <span class="close2">&times;</span>
                            <h2>Incerir</h2>
                        </div>
                        <div class="modalBody">
                            <label for="">Nome do Aluno</label>
                            <select name="user" id="" class="modalSelect">
                                <?php
                                    $sql = "select * from users";
                                    $result = mysqli_query($connection, $sql);

                                    while ($rows = mysqli_fetch_assoc($result)) {
                                ?>
                                    <option value="<?php echo $rows["user_id"]; ?>"><?php echo $rows["user"]; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <label for="">Nome do Curso</label>
                            <select name="course" id="" class="modalSelect">
                                <?php
                                    $sql = "select * from course";
                                    $result = mysqli_query($connection, $sql);

                                    while ($rows = mysqli_fetch_assoc($result)) {
                                ?>
                                    <option value="<?php echo $rows["course_id"]; ?>"><?php echo $rows["course_name"]; ?></option>
                                <?php
                                    }
                                ?>
                                </select>
                            <button type="submit" name="insert" class="btn">Inserir</button>
                        </div>
                        <div class="modalFooter">
                            <h3></h3>
                        </div>
                    </form>
                </div>
                <?php
                    if (isset($_GET["insert"])) {
                        echo "<script src='js/modals(insert).js'></script>";
                    }
                ?>
<!-------------------------------------------------Edit Modal------------------------------------------------->
                <div id="editModal" class="modal">
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modalHeader">
                            <span class="close">&times;</span>
                            <h2>Editar</h2>
                        </div>
                        <div class="modalBody">
                            <label for="">Nome do Aluno</label>
                            <select name="user" id="" class="modalSelect">
                                <?php
                                    $sql = "select * from users";
                                    $result = mysqli_query($connection, $sql);

                                    while ($rows = mysqli_fetch_assoc($result)) {
                                ?>
                                    <option value="<?php echo $rows["user_id"]; ?> " <?php if ($rows["user_id"] == $user) {echo "selected";} ?> ><?php echo $rows["user"]; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <label for="">Nome do Curso</label>
                            <select name="course" id="" class="modalSelect">
                                <?php
                                    $sql = "select * from course";
                                    $result = mysqli_query($connection, $sql);

                                    while ($rows = mysqli_fetch_assoc($result)) {
                                ?>
                                    <option value="<?php echo $rows["course_id"]; ?>" <?php if ($rows["course_id"] == $course) {echo "selected";} ?> ><?php echo $rows["course_name"]; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <button type="submit" name="update" class="btn">Salvar</button>
                        </div>
                        <div class="modalFooter">
                            <h3></h3>
                        </div>
                    </form>
                </div>
                <?php
                    if (isset($_GET["edit"])) {
                        echo "<script src='js/modals(edit).js'></script>";
                    }
                ?>
<!------------------------------------------------Delete Modal------------------------------------------------>
                <div id="deleteModal" class="modal">
                    <form action="" method="POST">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="modalHeader">
                            <span class="close1">&times;</span>
                            <h2>Deletar</h2>
                        </div>
                        <div class="modalBody">
                            <h3>Deseja realmente deletar <?php echo $user2 . "|" . $course2; ?>?</h3>
                            <button type="submit" name="delete" class="btn">Deletar</button>
                        </div>
                        <div class="modalFooter">
                            <h3></h3>
                        </div>
                    </form>
                </div>
                <?php
                    if (isset($_GET["delete"])) {
                        echo "<script src='js/modals(delete).js'></script>";
                    }
                ?>
<!------------------------------------------------------------------------------------------------------------>
            </div>
        </div>
    </section>
    <footer>
        <div class="footer">
            <p>© 2021 Copyright: Rafael G. Aires</p>
        </div>
    </footer>
    <script src=""></script>
</body>
</html>