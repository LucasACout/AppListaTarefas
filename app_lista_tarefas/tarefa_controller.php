<?php

  //Mudar caminho para o outro arquivo (tarefa_controller.php) na pasta publica saber o caminho
  //Todo esse código vai ser incluido no diretório publico - de forma segura
  //É como se eu estivesse escrevendo o código lá 
  require('../app_lista_tarefas/tarefa.model.php');
  require('../app_lista_tarefas/tarefa.service.php');
  require('../app_lista_tarefas/conexao.php');

  //Verifica se recebeu um parametro via url, senão, a variavel espera um valor para $acao;
  $acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

  if($acao == 'inserir'){
    $tarefa = new Tarefa();
    $tarefa->__set('tarefa', $_POST['tarefa']);

    $conexao = new Conexao();

    $tarefaService = new TarefaService($conexao, $tarefa);

    $tarefaService->inserir();

    header('Location: nova_tarefa.php?inclusao=1');
  } else if($acao == 'recuperar'){
  
    $tarefa = new Tarefa();
    $conexao = new Conexao();

    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefas = $tarefaService->recuperar();

  } else if($acao == 'atualizar'){

    $tarefa = new Tarefa();
    $tarefa->__set('id', $_POST['id']);
    $tarefa->__set('tarefa', $_POST['tarefa']);

    $conexao = new Conexao();
    $tarefaService = new TarefaService($conexao, $tarefa);

    if($tarefaService->atualizar()){

      if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
        header('Location: index.php'); 
      } else{
        header('Location: todas_tarefas.php');
      }

    }

  } else if($acao == 'remover'){

    $tarefa = new Tarefa();
    $tarefa->__set('id', $_GET['id']);
    $conexao = new Conexao();

    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefaService->remover();

    if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
      header('Location: index.php'); 
    } else{
      header('Location: todas_tarefas.php');
    }

  } else if($acao == 'realizada'){

    $tarefa = new Tarefa();
    $tarefa->__set('id', $_GET['id']);
    $tarefa->__set('id_status', 2);

    $conexao = new Conexao();

    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefaService->realizada();

    if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
      header('Location: index.php'); 
    } else{
      header('Location: todas_tarefas.php');
    }

  } else if($acao = 'recuperarTarefasPendentes'){

    $tarefa = new Tarefa();
    $tarefa->__set('id_status', 1);
    $conexao = new Conexao();

    $tarefaService = new TarefaService($conexao, $tarefa);
    $tarefas = $tarefaService->recuperarTarefasPendentes();

  }

?>