<?php

class ConsumoCombustivel {
    private static $numeroSerieAtual = 1;

    private $numeroSerie;
    private $capacidade;
    private $motorista;
    private $combustivel = 0;

    public function __construct($capacidade, $motorista) {
        $this->numeroSerie = str_pad(self::$numeroSerieAtual++, 2, '0', STR_PAD_LEFT);
        $this->capacidade = $capacidade;
        $this->motorista = $motorista;
    }

    public function abastecer($litros) {
        while ($litros <= 0 || $this->combustivel + $litros > $this->capacidade) {
            if ($litros <= 0) {
                echo "A quantidade de litros deve ser maior que zero.\n";
            } else {
                echo "O tanque não suporta abastecer $litros litros. Capacidade máxima: {$this->capacidade} litros.\n";
            }

            $litros = readline("Digite uma quantida de válida de litros para o motorista {$this->motorista}: ");
        }

        $this->combustivel += $litros;
        echo "$litros litros abastecidos com sucesso para o motorista {$this->motorista}.\n";
    }

    public function rodar($distancia) {
        $distancia = intval($distancia); // Convertendo para inteiro
        if ($this->combustivel >= $distancia) {
            $litrosGastos = $distancia;
            $this->combustivel -= $distancia;
            return "O motorista {$this->motorista} percorreu {$distancia} km, gastando {$litrosGastos} litros. Restam {$this->combustivel} litros.";
        } else {
            return "Não há combustível suficiente para percorrer {$distancia} km. Abasteça o carro.";
        }
    }

    public function contar() {
        return $this->combustivel;
    }

    public function getMotorista() {
        return $this->motorista;
    }

    public function getNumeroSerie() {
        return $this->numeroSerie;
    }
}

class Principal {
    private $carros = [];

    public function criarCarros() {
        for ($i = 1; $i <= 3; $i++) {
            $capacidade = readline("Digite a capacidade do tanque para o carro $i (em litros): ");
            $motoristaNome = readline("Digite o nome do motorista para o carro $i: ");

            $carro = new ConsumoCombustivel(floatval($capacidade), $motoristaNome);
            $this->carros[] = $carro;
        }
    }

    public function carregarCombustivel() {
        foreach ($this->carros as $carro) {
            $litros = readline("Digite a quantidade de litros para o motorista {$carro->getMotorista()}: ");
            $carro->abastecer(floatval($litros));
        }
    }

    public function dispararContinuamente() {
        while (true) {
            $distancia = readline("Digite a distância a percorrer (ou 0 para sair): ");
            if ($distancia == 0) {
                break;
            }

            foreach ($this->carros as $carro) {
                $mensagem = $carro->rodar($distancia);
                echo "Número de Série: {$carro->getNumeroSerie()}, Motorista {$carro->getMotorista()}: {$carro->contar()} litros, $mensagem\n";
            }
            echo "\n";
        }
    }
}

// Teste das classes
$principal = new Principal();
$principal->criarCarros();
$principal->carregarCombustivel();
$principal->dispararContinuamente();
