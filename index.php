<?php

function mostrarTabuleiro($board)
{
    echo <<<EOL

         Posições: | Tabuleiro
                   |
           0|1|2   |   $board[0]|$board[1]|$board[2]
           3|4|5   |   $board[3]|$board[4]|$board[5]
           6|7|8   |   $board[6]|$board[7]|$board[8]


        EOL;
}

function verificarVencedor($board, $symbol)
{
    $combinacoes = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8],  
        [0, 3, 6], [1, 4, 7], [2, 5, 8],  
        [0, 4, 8], [2, 4, 6]              
    ];

    foreach ($combinacoes as $combinacaoVencedor) {
        if ($board[$combinacaoVencedor[0]] === $symbol &&
            $board[$combinacaoVencedor[1]] === $symbol &&
            $board[$combinacaoVencedor[2]] === $symbol) {
            return true;
        }
    }

    return false;
}

function realizarJogada(&$board, $position, $player)
{
    $board[$position] = $player;
}

function jogarNovamente()
{
    return filter_var(
        readline("\nJogar novamente? (true/false): "),
        FILTER_VALIDATE_BOOLEAN
    );
}

function main()
{
    do {
        $player1 = readline('Jogador 1 (X) - Seu nome: ');
        $player2 = readline('Jogador 2 (O) - Seu nome: ');

        $players = ['X' => $player1, 'O' => $player2];
        $jogadorDaVez = 'X';

        $board = array_fill(0, 9, '.');

        $vencedor = null;

        while ($vencedor === null) {
            mostrarTabuleiro($board);

            $position = (int)readline("{$players[$jogadorDaVez]}, digite a sua posição: ");

            if (!in_array($position, range(0, 8))) {
                echo "\nPosição inexistente, digite novamente.\n";
                continue;
            }

            if ($board[$position] !== '.') {
                echo "\nPosição ocupada, digite novamente.\n";
                continue;
            }

            realizarJogada($board, $position, $jogadorDaVez);

            if (verificarVencedor($board, $jogadorDaVez)) {
                $vencedor = $jogadorDaVez;
            } elseif (!in_array('.', $board)) {
                break;
            }

            $jogadorDaVez = ($jogadorDaVez === 'X') ? 'O' : 'X';
        }

        mostrarTabuleiro($board);

        if ($vencedor !== null) {
            echo "VENCEDOR: {$players[$vencedor]}.\n";
        } else {
            echo "EMPATE.\n";
        }

    } while (jogarNovamente());

    echo "\nObrigada por jogar!\n";
}

main();
?>
