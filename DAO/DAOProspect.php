<?php

/**
 * Classe DAOProspect
 * Responsável pela comunicação com o banco de dados
 * Oferece operações CRUD para objetos do tipo Prospect
 */
class DAOProspect {
    
    /**
     * Inclui um novo prospect no banco de dados
     * 
     * @param string $nome Nome do prospect
     * @param string $email Email do prospect
     * @param string $celular Número de celular
     * @param string $facebook Link do perfil no Facebook
     * @param string $whatsapp Número do WhatsApp
     * @return bool TRUE em caso de sucesso
     * @throws Exception Em caso de erro na inserção
     */
    public function incluirProspect($nome, $email, $celular, $facebook, $whatsapp) {
        try {
            $conexao = $this->conectarBanco();
            
            $sql = "INSERT INTO prospect (nome, email, celular, facebook, whatsapp) 
                    VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $conexao->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("Erro ao preparar statement: " . $conexao->error);
            }
            
            $stmt->bind_param("sssss", $nome, $email, $celular, $facebook, $whatsapp);
            
            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar inserção: " . $stmt->error);
            }
            
            $stmt->close();
            $conexao->close();
            
            return true;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao incluir prospect: " . $e->getMessage());
        }
    }
    
    /**
     * Atualiza os dados de um prospect existente
     * 
     * @param string $nome Novo nome
     * @param string $email Novo email
     * @param string $celular Novo celular
     * @param string $facebook Novo link do Facebook
     * @param string $whatsapp Novo número do WhatsApp
     * @param int $codProspect Código identificador do prospect
     * @return bool TRUE em caso de sucesso
     * @throws Exception Em caso de falha na atualização
     */
    public function atualizarProspect($nome, $email, $celular, $facebook, $whatsapp, $codProspect) {
        try {
            $conexao = $this->conectarBanco();
            
            $sql = "UPDATE prospect 
                    SET nome = ?, email = ?, celular = ?, facebook = ?, whatsapp = ? 
                    WHERE cod_prospect = ?";
            
            $stmt = $conexao->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("Erro ao preparar statement: " . $conexao->error);
            }
            
            $stmt->bind_param("sssssi", $nome, $email, $celular, $facebook, $whatsapp, $codProspect);
            
            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar atualização: " . $stmt->error);
            }
            
            $stmt->close();
            $conexao->close();
            
            return true;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar prospect: " . $e->getMessage());
        }
    }
    
    /**
     * Remove um prospect do banco de dados
     * 
     * @param int $codProspect Código identificador do prospect
     * @return bool TRUE em caso de sucesso
     * @throws Exception Em caso de erro na exclusão
     */
    public function excluirProspect($codProspect) {
        try {
            $conexao = $this->conectarBanco();
            
            $sql = "DELETE FROM prospect WHERE cod_prospect = ?";
            
            $stmt = $conexao->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("Erro ao preparar statement: " . $conexao->error);
            }
            
            $stmt->bind_param("i", $codProspect);
            
            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar exclusão: " . $stmt->error);
            }
            
            $stmt->close();
            $conexao->close();
            
            return true;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir prospect: " . $e->getMessage());
        }
    }
    
    /**
     * Recupera prospects do banco de dados
     * 
     * @param string|null $email Email do prospect (opcional)
     * @return array Array de objetos Prospect
     * @throws Exception Em caso de erro na consulta
     */
    public function buscarProspects($email = null) {
        try {
            $conexao = $this->conectarBanco();
            $prospects = array();
            
            if ($email !== null) {
                $sql = "SELECT cod_prospect, nome, email, celular, facebook, whatsapp 
                        FROM prospect WHERE email = ?";
                $stmt = $conexao->prepare($sql);
                
                if (!$stmt) {
                    throw new Exception("Erro ao preparar statement: " . $conexao->error);
                }
                
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $resultado = $stmt->get_result();
                
            } else {
                $sql = "SELECT cod_prospect, nome, email, celular, facebook, whatsapp 
                        FROM prospect";
                $resultado = $conexao->query($sql);
                
                if (!$resultado) {
                    throw new Exception("Erro ao executar consulta: " . $conexao->error);
                }
            }
            
            while ($row = $resultado->fetch_assoc()) {
                $prospect = new Prospect();
                $prospect->addProspect(
                    $row['cod_prospect'],
                    $row['nome'],
                    $row['email'],
                    $row['celular'],
                    $row['facebook'],
                    $row['whatsapp']
                );
                $prospects[] = $prospect;
            }
            
            if (isset($stmt)) {
                $stmt->close();
            }
            $conexao->close();
            
            return $prospects;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar prospects: " . $e->getMessage());
        }
    }
    
    /**
     * Estabelece conexão com o banco de dados MySQL
     * 
     * @return mysqli Objeto MySQLi representando a conexão
     * @throws Exception Em caso de falha na conexão
     */
    private function conectarBanco() {
        try {
            require_once(BASE_DIR . DS . 'configdb.php');
            
            $conexao = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            if ($conexao->connect_error) {
                throw new Exception("Falha na conexão: " . $conexao->connect_error);
            }
            
            $conexao->set_charset("utf8");
            
            return $conexao;
            
        } catch (Exception $e) {
            throw new Exception("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }
    }
}

?>