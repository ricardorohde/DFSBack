# DFSBack
Sistema de Gerenciamento do site DFS

Após criar o banco execute a seguinte query:

```
INSERT INTO `tta_usuarios` (`id`, `nivel`, `nome`, `login`, `senha`, `imagem`, `texto`, `ensino`) VALUES
(1, 1, 'Administrador', 'dfs', '123', '', '', '');
```

Não esquece de alterar os dados do Banco no arquivo lib.conf/conf.php.