<?php

/**
 * Интерфейс Абстрактной Фабрики объявляет набор методов, которые возвращают
 * различные абстрактные продукты. Эти продукты называются семейством и связаны
 * темой или концепцией высокого уровня. Продукты одного семейства обычно могут
 * взаимодействовать между собой. Семейство продуктов может иметь несколько
 * вариаций, но продукты одной вариации несовместимы с продуктами другой.
 */
abstract class AbstractFactory
{
    abstract public function createTable() : Table;

    abstract public function createSofa() : Sofa;

    public function combineTableSofa()
    {

        $table = $this->createTable();
        $sofa = $this->createSofa();
        $sofa->anotherUsefulFunctionB($table);
    }
}

/**
 * Конкретная Фабрика производит семейство продуктов одной вариации. Фабрика
 * гарантирует совместимость полученных продуктов. Обратите внимание, что
 * сигнатуры методов Конкретной Фабрики возвращают абстрактный продукт, в то
 * время как внутри метода создается экземпляр конкретного продукта.
 */
class ArDekoFactory extends AbstractFactory
{
    public function createTable() : Table
    {

        return new ArDekoTable();
    }

    public function createSofa() : Sofa
    {

        return new ArDekoSofa();
    }
}

/**
 * Каждая Конкретная Фабрика имеет соответствующую вариацию продукта.
 */
class ModernFactory extends AbstractFactory
{
    public function createTable() : Table
    {

        return new ModernTable();
    }

    public function createSofa() : Sofa
    {

        return new ModernSofa();
    }
}

/**
 * Каждый отдельный продукт семейства продуктов должен иметь базовый интерфейс.
 * Все вариации продукта должны реализовывать этот интерфейс.
 */
interface Table
{
    public function usefulFunctionA() : string;
}

/**
 * Конкретные продукты создаются соответствующими Конкретными Фабриками.
 */
class ArDekoTable implements Table
{
    public function usefulFunctionA() : string
    {

        return "The result of the product A1.";
    }
}

class ModernTable implements Table
{
    public function usefulFunctionA() : string
    {

        return "The result of the product A2.";
    }
}

/**
 * Базовый интерфейс другого продукта. Все продукты могут взаимодействовать друг
 * с другом, но правильное взаимодействие возможно только между продуктами одной
 * и той же конкретной вариации.
 */
interface Sofa
{
    /**
     * Продукт B способен работать самостоятельно...
     */
    public function usefulFunctionB() : string;

    /**
     * ...а также взаимодействовать с Продуктами A той же вариации.
     *
     * Абстрактная Фабрика гарантирует, что все продукты, которые она создает,
     * имеют одинаковую вариацию и, следовательно, совместимы.
     */
    public function anotherUsefulFunctionB(Table $collaborator) : string;
}

/**
 * Конкретные Продукты создаются соответствующими Конкретными Фабриками.
 */
class ArDekoSofa implements Sofa
{
    public function usefulFunctionB() : string
    {

        return "The result of the product B1.";
    }

    /**
     * Продукт B1 может корректно работать только с Продуктом A1. Тем не менее,
     * он принимает любой экземпляр Абстрактного Продукта А в качестве
     * аргумента.
     */
    public function anotherUsefulFunctionB(Table $collaborator) : string
    {

        $result = $collaborator->usefulFunctionA();

        return "The result of the B1 collaborating with the ({$result})";
    }
}

class ModernSofa implements Sofa
{
    public function usefulFunctionB() : string
    {

        return "The result of the product B2.";
    }

    /**
     * Продукт B2 может корректно работать только с Продуктом A2. Тем не менее,
     * он принимает любой экземпляр Абстрактного Продукта А в качестве
     * аргумента.
     */
    public function anotherUsefulFunctionB(Table $collaborator) : string
    {

        $result = $collaborator->usefulFunctionA();

        return "The result of the B2 collaborating with the ({$result})";
    }
}

/**
 * Клиентский код работает с фабриками и продуктами только через абстрактные
 * типы: Абстрактная Фабрика и Абстрактный Продукт. Это позволяет передавать
 * любой подкласс фабрики или продукта клиентскому коду, не нарушая его.
 */
function clientCode(AbstractFactory $factory)
{

    $productTable = $factory->createTable();
    $productSofa = $factory->createSofa();

    echo $productSofa->usefulFunctionB() . "\n";
    echo $productSofa->anotherUsefulFunctionB($productTable) . "\n";
}

/**
 * Клиентский код может работать с любым конкретным классом фабрики.
 */
echo "Client: Testing client code with the first factory type:\n";
clientCode(new ArDekoFactory());

echo "\n";

echo "Client: Testing the same client code with the second factory type:\n";
clientCode(new ModernFactory());
