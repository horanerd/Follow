<?php
/* 
 * Classe responsál por fazer o gerenciamento dos seguidores do sistema.
 */


/**
 * follow.class.php
 *
 * @copyright (c) 2016, Guilherme De Sousa, HORANERD SOLUÇÃO EM INFORMATICA
 */
class Follow {
   private $Follow;
   private $Unfollow;
   private $Userone;
   private $Usertwo;
   private $Tabela;
   private $Termos;
   private $ParseString;
   
   // Metodo responsavel por inserir os seguidores ao banco de dados
   public function GetFollow($Userone, $Usertwo, $Tabela){
       $this->Userone = (string)$Userone;
       $this->Usertwo = (string)$Usertwo;
       $this->Tabela = (string)$Tabela;
       $create = new Create;
       $dados = ['user_one' => $Userone, 'user_two' => $Usertwo, 'date' => date('d/m/Y'), 'hora' => date('H:i:s')];
       $create ->ExeCreate($Tabela, $dados);
              
   }
   // Metodo resposavel por excluir os seguidores do banco de dados
   public function Unfollow($Userone, $Usertwo, $Tabela){
      $this->Tabela = (string)$Tabela;
      $this->Userone = (string)$Userone;
       $this->Usertwo = (string)$Usertwo;
      $delete = new Delete;
      $termos = "WHERE user_one = :userone AND user_two = :usertwo";
      $ParseString = "userone={$Userone}&usertwo={$Usertwo}";
      $delete ->ExeDelete($Tabela, $termos, $ParseString);
   }
   // Metodo responsavel por exibir os seguidores
   public function ExibiFollow($Usertwo,$Tabela){
       $this->Usertwo = $Usertwo;
       $this->Tabela = $Tabela;
       $read = new Read;
       $Termos = "WHERE user_two = :usertwo";
       $Parte = "usertwo={$Usertwo}";
       $read ->ExeRead($Tabela, $Termos, $Parte);
       
       $result = $read->getRowCount();
       if($result >= 1):
           foreach ($read ->getResult() as $cat):
               extract($cat);
           
           $user = new Read;
           $user->ExeRead('users', 'WHERE id = :id', "id={$user_one}");
           foreach ($user ->getResult() as $dog):
               extract($dog);
           
           echo "<div class='relac' >
                    
                    <a href='user?id={$user_one}'><img src='{$foto}' height='100px' width='250px'></a>
                        <p>seguidor desde {$date} as {$hora}</p>
                    
     </div> ";
           endforeach;
           endforeach;
           
       
           
       else:
           echo "<h1>Desculpe, mas você não possui seguidores</h1>";
       endif;
   }
   
}
