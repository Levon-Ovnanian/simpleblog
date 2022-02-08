<?php include __DIR__ . '/../main/header.php'; ?>

<h1>Редактирование статьи</h1>

<?php if (!empty($error)): ?>
    <div style="color: red;"><?= $error; ?></div>
<?php endif; ?>
<?php if (empty($_POST['name']) OR !strlen(trim($_POST['name']))) : ;?>
    <?php $valueName = $article->getName(); ?>
<?php else: ;?>
    <?php $valueName = $_POST['name']; ?>    
<?php endif; ?>
<?php if (empty($_POST['text']) OR !strlen(trim($_POST['text']))): ;?>
    <?php $valueText = $article->getText(); ?>
<?php else: ;?>
    <?php $valueText = $_POST['text']; ?>    
<?php endif; ?>        
    <form action="/articles/<?= $article->getId(); ?>/edit/<?= $currentPage; ?>/<?= $orderBy; ?>/<?= $searchPanelArgs[0]; ?>/<?= $searchPanelArgs[1]; ?>" method="post">
        <label for="name">Название статьи</label><br>
        <input type="text" name="name" id="name" value="<?= $valueName; ?>" size="50"><br>
        <br>
        <label for="text">Текст статьи</label><br>
        <textarea name="text" id="text" rows="10" cols="80" value=""><?= $valueText; ?></textarea>
        <br>
        <br>
        <input type="submit" value="Обновить">
    </form>
    
<?php include __DIR__ . '/../main/footer.php'; ?>
