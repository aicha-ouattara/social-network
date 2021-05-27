	</main>
	<?php foreach ($this->jsList as $name): ?>
		<script src="<?= JS.$name?>"></script>
	<?php endforeach; ?>
		<script src="http://localhost:443/socket.io/socket.io.js"></script>
	</body>
	<footer>
		Ceci est le footer!
	</footer>
</html>
