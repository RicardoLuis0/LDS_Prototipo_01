<?php
use Session\Session;
echo "<p>Bem Vindo, ".Session::getUserData()->getName()."</p>";