DROP DATABASE IF EXISTS `sgt`;
CREATE DATABASE IF NOT EXISTS `sgt` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `sgt`;


-- Copiando estrutura para tabela sgt.usuario
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
   `nm_pessoa` varchar(30) NOT NULL,
  `nm_usuario` varchar(50) NOT NULL,
  `ds_senha` varchar(50) NOT NULL,
  `ds_ativo` int(11) NOT NULL,
  `ds_permissao` int(11) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela sgt.usuario: ~0 rows (aproximadamente)
DELETE FROM `usuario`;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`id_usuario`, `nm_usuario`, `ds_senha`, `ds_ativo`, `ds_permissao`) VALUES
	(1, 'wells', '202cb962ac59075b964b07152d234b70', 1, 1),
	(2, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 1);

CREATE TABLE tipoPessoa(
  cd_tipo_pessoa INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nm_tipo_pessoa VARCHAR(30) UNIQUE
);
CREATE TABLE multa(
  id_multa INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  cd_ait INT NOT NULL UNIQUE,
  nm_modalidade VARCHAR(30),
  cd_modalidade INT,
  nm_infracao VARCHAR(50),
  dt_infracao DATE NOT NULL,
  hr_infracao VARCHAR(5) NOT NULL,
  dt_vencimento_infracao DATE NOT NULL,
  nm_agente VARCHAR(30) NOT NULL,
  ds_observacao VARCHAR(100) NOT NULL,
  dt_pagamento_multa DATE
);
CREATE TABLE infracao(
  id_infracao INT NOT NULL PRIMARY KEY AUTO_INCREMENT,  
  cd_infracao INT NOT NULL,
  nm_tipo_multa VARCHAR(1) NOT NULL,
  nm_infracao VARCHAR(20) NOT NULL,  
  qt_pontuacao INT NOT NULL, 
  vl_infracao DOUBLE NOT NULL,
CHECK(vl_infracao > 0)
);
CREATE TABLE tipoVeiculo(
  cd_modalidade INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nm_modalidade VARCHAR(30) NOT NULL
);
CREATE TABLE processo(
  id_processo INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  cd_processo INT NOT NULL UNIQUE,
  aa_processo VARCHAR(4) NOT NULL,
  dt_relato_denuncia DATE NOT NULL,
  dt_apresentacao_defesa DATE,
  dt_apresentacao_relatorio DATE,
  dt_inicio_julgamento DATE,
  dt_julgado DATE,
  ds_resultado VARCHAR(30),
  dt_notificacao DATE,
  ds_observacoes_processos VARCHAR(100),
  nm_modalidade VARCHAR(30) NOT NULL
  );
  
  CREATE TABLE recurso(
  id_recurso INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  cd_recurso INT NOT NULL UNIQUE,
  cd_processo INT NOT NULL,
  aa_recurso VARCHAR(4) NOT NULL,
  dt_transito_julgado DATE,
  dt_inicio_julgamento_recurso DATE,
  dt_julgado_recurso DATE,
  ds_resultado_recurso VARCHAR(30),
  dt_notificacao_recurso DATE,
  dt_arquivo_deprot DATE,
  ds_observacao_recurso VARCHAR(100),
  CONSTRAINT fkrecuro_cd_processo FOREIGN KEY(cd_processo) REFERENCES processo(cd_processo)
);
CREATE TABLE associacao(
  cd_associacao INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nm_razao_social VARCHAR(40) NOT NULL,
  nm_local VARCHAR(50) NOT NULL,
  ds_numero INT NOT NULL,
  ds_complemento VARCHAR(15),
  cd_cep INT NOT NULL,
  nm_bairro VARCHAR(10) NOT NULL,
  nm_municipio VARCHAR(15) NOT NULL,
  nm_UF CHAR(2) NOT NULL,
  cd_telefone VARCHAR(13) NOT NULL,
  nm_email VARCHAR(25) NOT NULL,
  nm_linha VARCHAR(15) NOT NULL,
  CONSTRAINT cnm_UF
CHECK
  (
    nm_UF IN(
      'AC',
      'AL',
      'AP',
      'AM',
      'BA',
      'CE',
      'DF',
      'ES',
      'GO',
      'MA',
      'MT',
      'MS',
      'MG',
      'PR',
      'PB',
      'PA',
      'PE',
      'PI',
      'RJ',
      'RN',
      'RS',
      'RO',
      'RR',
      'SC',
      'SE',
      'SP',
      'TO'
    )
  )
);
CREATE TABLE pessoa(
  cd_pessoa INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nm_tipo_pessoa VARCHAR(30),
  nm_pessoa VARCHAR(50) NOT NULL,
  nm_associacao VARCHAR(30),
  nm_local VARCHAR(50) NOT NULL,
  cd_endereco INT NOT NULL,
  ds_complemento VARCHAR(20),
  cd_cep INT NOT NULL,
  nm_bairro VARCHAR(30) NOT NULL,
  nm_municipio VARCHAR(35) NOT NULL,
  nm_UF CHAR(2) NOT NULL,
  cd_telefone VARCHAR(13) NOT NULL,
  cd_celular VARCHAR(14) NOT NULL,
  nm_email VARCHAR(25) NOT NULL,
  cd_rg VARCHAR(12) NOT NULL,
  nm_uf_rg CHAR(2) NOT NULL,
  cd_cpf VARCHAR(15) NOT NULL,
  cd_titulo_eleitor INT NOT NULL,
  cd_zona INT NOT NULL,
  cd_secao_eleitoral INT NOT NULL,
  dt_nascimento DATE NOT NULL,
  cd_certidao_reservista VARCHAR(10),
  cd_serie CHAR(1),
  dt_atestado_antecedente_criminais DATE,
  cd_cnh INT,
  nm_categoria CHAR(1),
  dt_expedicao_cnh DATE,
  dt_renovacao_cnh DATE,
  dt_direcao_defensiva DATE,
  cd_gerenciamento_detran INT,
  dt_credenciamento_detran DATE,
  cd_carteirinha INT,
  dt_validade_carteirinha DATE,
  cd_inscricao_iss VARCHAR(15),
  ds_carteira VARCHAR(50),
  dt_inicio DATE,
  ds_inativo INT(11),
 
  CONSTRAINT fknm_tipo_pessoa FOREIGN KEY(nm_tipo_pessoa) REFERENCES tipoPessoa(nm_tipo_pessoa),
  CONSTRAINT cnm_UF
CHECK
  (
    nm_UF IN(
      'AC',
      'AL',
      'AP',
      'AM',
      'BA',
      'CE',
      'DF',
      'ES',
      'GO',
      'MA',
      'MT',
      'MS',
      'MG',
      'PR',
      'PB',
      'PA',
      'PE',
      'PI',
      'RJ',
      'RN',
      'RS',
      'RO',
      'RR',
      'SC',
      'SE',
      'SP',
      'TO'
    )
  ),
  CONSTRAINT cnm_uf_rg
CHECK
  (
    nm_uf_rg IN(
      'AC',
      'AL',
      'AP',
      'AM',
      'BA',
      'CE',
      'DF',
      'ES',
      'GO',
      'MA',
      'MT',
      'MS',
      'MG',
      'PR',
      'PB',
      'PA',
      'PE',
      'PI',
      'RJ',
      'RN',
      'RS',
      'RO',
      'RR',
      'SC',
      'SE',
      'SP',
      'TO'
    )
  )
);
CREATE TABLE veiculo(
  cd_veiculo INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  cd_pessoa INT NOT NULL,
  nm_tipo_pessoa VARCHAR(30) NOT NULL,
  cd_ait INT,
  cd_processo INT,
  cd_modalidade INT NOT NULL,
  cd_associacao INT NOT NULL,
  cd_placa VARCHAR(8) NOT NULL UNIQUE,
  cd_prefixo VARCHAR(10) NOT NULL,
  nm_fabricante VARCHAR(30) NOT NULL,
  nm_modelo VARCHAR(30) NOT NULL,
  nm_cor VARCHAR(8) NOT NULL,
  aa_fabricacao VARCHAR(4) NOT NULL,
  aa_modelo VARCHAR(4) NOT NULL,
  nm_municipio_vec VARCHAR(15) NOT NULL,
  nm_UF CHAR(2) NOT NULL,
  ds_permissao_publicidade INT(1),
  ds_particular INT(1),
  cd_renavam INT NOT NULL,
  vl_vencimento_seguro DATE NOT NULL,
  cd_alvara INT,
  ds_alvara VARCHAR(50),
  dt_emissao_alvara DATE,
  dt_validade_alvara DATE,
  CONSTRAINT fkveiculo_cd_ait FOREIGN KEY(cd_ait) REFERENCES multa(cd_ait),
  CONSTRAINT fkveiculo_cd_processo FOREIGN KEY(cd_processo) REFERENCES processo(cd_processo),
  CONSTRAINT fkcd_modalidade FOREIGN KEY(cd_modalidade) REFERENCES tipoVeiculo(cd_modalidade),
  CONSTRAINT fkcd_associacao FOREIGN KEY(cd_associacao) REFERENCES associacao(cd_associacao),
  CONSTRAINT cnm_UF
CHECK
  (
    nm_UF IN(
      'AC',
      'AL',
      'AP',
      'AM',
      'BA',
      'CE',
      'DF',
      'ES',
      'GO',
      'MA',
      'MT',
      'MS',
      'MG',
      'PR',
      'PB',
      'PA',
      'PE',
      'PI',
      'RJ',
      'RN',
      'RS',
      'RO',
      'RR',
      'SC',
      'SE',
      'SP',
      'TO'
    )
  )
);
ALTER TABLE
  `veiculo` ADD CONSTRAINT `fkveiculo_cd_pessoa` FOREIGN KEY(`cd_pessoa`) REFERENCES `pessoa`(`cd_pessoa`);
ALTER TABLE
  `veiculo` ADD CONSTRAINT `fkveiculo_nm_tipo_pessoa` FOREIGN KEY(`nm_tipo_pessoa`) REFERENCES `pessoa`(`nm_tipo_pessoa`);

CREATE TABLE vistoria(
  cd_vistoria INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  cd_placa VARCHAR(8) NOT NULL,  
  cd_modalidade INT NOT NULL,  
  dt_vistoria DATE NOT NULL,
  ds_resultado VARCHAR(100) NOT NULL,
  nm_vistoria VARCHAR(20) NOT NULL,
  ds_observacao VARCHAR(50),
  CONSTRAINT fkvistoria_cd_placa FOREIGN KEY(cd_placa) REFERENCES veiculo(cd_placa) ON UPDATE CASCADE ON DELETE CASCADE ,  
  CONSTRAINT fkvistoria_cd_modalidade FOREIGN KEY(cd_modalidade) REFERENCES veiculo(cd_modalidade) ON UPDATE CASCADE
);
