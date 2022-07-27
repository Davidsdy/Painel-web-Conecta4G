<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/login.php");
if (getLogged($sid) == true) {
	header("location: home.php");
} else {
?>

	<section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
		<div class="container">
			<div class="row justify-content-center form-bg-image">
				<div class="col-12 d-flex align-items-center justify-content-center">
					<div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
						<div class="text-center text-md-center mb-4 mt-md-0">
							<h1 class="mb-0 h3">Painel Conecta4G</h1>
						</div>
						<?php
						if (isset($_SESSION['erro'])) : echo $_SESSION['erro'];
							session_destroy();
						endif; ?>
						<form action="" method="POST" class="mt-4">
							<!-- Form -->
							<div class="form-group mb-4">
								<label for="email">Usuário</label>
								<div class="input-group">
									<span class="input-group-text" id="basic-addon1">
										<svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
											<path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
											<path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
										</svg>
									</span>
									<input type="text" class="form-control" placeholder="Usuário" name="login" autofocus required>
								</div>
							</div>
							<!-- End of Form -->
							<div class="form-group">
								<!-- Form -->
								<div class="form-group mb-4">
									<label for="password">Senha</label>
									<div class="input-group">
										<span class="input-group-text" id="basic-addon2">
											<svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
												<path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
											</svg>
										</span>
										<input type="password" placeholder="Senha" class="form-control" name="senha" required>
									</div>
								</div>
								<!-- End of Form -->
								<div class="d-flex justify-content-between align-items-top mb-4">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="" id="remember">
										<label class="form-check-label mb-0" for="remember">
											Lembre-me
										</label>
									</div>
									<div></div>
								</div>
							</div>
							<div class="d-grid">
								<button type="submit" name="btn_login" class="btn btn-gray-800">Entrar</button>
							</div>
						</form>
						<div class="d-flex justify-content-center align-items-center mt-4">
							<span class="fw-normal">
								Desenvolvido by
								<a href="https://t.me/Davidsdy" class="fw-bold">Davidsdy</a>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	</main>

<?php
}
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/rodape.php"); ?>