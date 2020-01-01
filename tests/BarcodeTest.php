<?php

use PHPUnit\Framework\TestCase;

class BarcodeTest extends TestCase
{
    public function test_png_barcode_generator_can_generate_code_128_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        $generated = $generator->getBarcode('081231723897', $generator::TYPE_CODE_128);

        $this->assertEquals('PNG', substr($generated, 1, 3));
    }

    public function test_svg_barcode_generator_can_generate_ean_13_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $generated = $generator->getBarcode('081231723897', $generator::TYPE_EAN_13);

        $this->assertStringEqualsFile('tests/verified-files/081231723897-ean13.svg', $generated);
    }

    public function test_html_barcode_generator_can_generate_code_128_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        $generated = $generator->getBarcode('081231723897', $generator::TYPE_CODE_128);

        $this->assertStringEqualsFile('tests/verified-files/081231723897-code128.html', $generated);
    }

    public function test_jpg_barcode_generator_can_generate_code_128_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
        $result = $generator->getBarcode('081231723897', $generator::TYPE_CODE_128);

        $this->assertGreaterThan(1000, strlen($result));
    }

    public function test_ean13_generator_throws_exception_if_invalid_chars_are_used()
    {
        $this->expectException(Picqer\Barcode\Exceptions\InvalidCharacterException::class);

        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $generator->getBarcode('A123', $generator::TYPE_EAN_13);
    }

    public function test_ean13_generator_accepting_13_chars()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $generated = $generator->getBarcode('0049000004632', $generator::TYPE_EAN_13);

        $this->assertStringEqualsFile('tests/verified-files/0049000004632-ean13.svg', $generated);
    }

    public function test_ean13_generator_accepting_12_chars_and_generates_13th_check_digit()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $generated = $generator->getBarcode('004900000463', $generator::TYPE_EAN_13);

        $this->assertStringEqualsFile('tests/verified-files/0049000004632-ean13.svg', $generated);
    }

    public function test_ean13_generator_accepting_11_chars_and_generates_13th_check_digit_and_adds_leading_zero()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $generated = $generator->getBarcode('04900000463', $generator::TYPE_EAN_13);

        $this->assertStringEqualsFile('tests/verified-files/0049000004632-ean13.svg', $generated);
    }

    public function test_ean13_generator_throws_exception_when_wrong_check_digit_is_given()
    {
        $this->expectException(Picqer\Barcode\Exceptions\InvalidCheckDigitException::class);

        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $generator->getBarcode('0049000004633', $generator::TYPE_EAN_13);
    }

    public function test_generator_throws_unknown_type_exceptions()
    {
        $this->expectException(Picqer\Barcode\Exceptions\UnknownTypeException::class);

        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $generator->getBarcode('0049000004633', 'vladimir');
    }

    public function test_generator_can_generate_code_39_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234567890abcABC', $generator::TYPE_CODE_39);

        $this->assertStringEqualsFile('tests/verified-files/C39-1234567890abcABC.svg', $result);
    }

    public function test_generator_can_generate_code_39_checksum_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234567890abcABC', $generator::TYPE_CODE_39_CHECKSUM);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_code_39_extended_checksum_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234567890abcABC', $generator::TYPE_CODE_39E_CHECKSUM);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_code_93_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234567890abcABC', $generator::TYPE_CODE_93);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_standard_2_5_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234567890', $generator::TYPE_STANDARD_2_5);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_standard_2_5_checksum_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234567890', $generator::TYPE_STANDARD_2_5_CHECKSUM);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_interleaved_2_5_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234567890', $generator::TYPE_INTERLEAVED_2_5);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_interleaved_2_5_checksum_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234567890', $generator::TYPE_INTERLEAVED_2_5_CHECKSUM);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_code_128_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234567890abcABC-283*33', $generator::TYPE_CODE_128);

        $this->assertStringEqualsFile('tests/verified-files/1234567890abcABC-283*33-code128.svg', $result);
    }

    public function test_generator_can_generate_code_128_a_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234567890', $generator::TYPE_CODE_128_A);

        $this->assertStringEqualsFile('tests/verified-files/1234567890-code128a.svg', $result);
    }

    public function test_generator_can_generate_code_128_b_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234567890abcABC-283*33', $generator::TYPE_CODE_128_B);

        $this->assertStringEqualsFile('tests/verified-files/1234567890abcABC-283*33-code128b.svg', $result);
    }

    public function test_generator_can_generate_code_128_c_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234567890', $generator::TYPE_CODE_128_C);

        $this->assertStringEqualsFile('tests/verified-files/1234567890-code128c.svg', $result);
    }

    public function test_generator_can_generate_ean_2_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234567890abcABC-283*33', $generator::TYPE_EAN_2);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_ean_5_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234567890abcABC-283*33', $generator::TYPE_EAN_5);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_ean_8_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234568', $generator::TYPE_EAN_8);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_ean_13_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('1234567890', $generator::TYPE_EAN_13);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_upc_a_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('123456789', $generator::TYPE_UPC_A);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_upc_e_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('123456789', $generator::TYPE_UPC_E);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_msi_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('123456789', $generator::TYPE_MSI);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_msi_checksum_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('123456789', $generator::TYPE_MSI_CHECKSUM);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_postnet_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('123456789', $generator::TYPE_POSTNET);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_planet_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('123456789', $generator::TYPE_PLANET);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_rms4cc_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('123456789', $generator::TYPE_RMS4CC);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_kix_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('123456789', $generator::TYPE_KIX);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_imb_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('123456789', $generator::TYPE_IMB);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_codabar_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('123456789', $generator::TYPE_CODABAR);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_code_11_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('123456789', $generator::TYPE_CODE_11);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_pharma_code_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('123456789', $generator::TYPE_PHARMA_CODE);

        $this->assertGreaterThan(100, strlen($result));
    }

    public function test_generator_can_generate_pharma_code_2_tracks_barcode()
    {
        $generator = new Picqer\Barcode\BarcodeGeneratorSVG();
        $result = $generator->getBarcode('123456789', $generator::TYPE_PHARMA_CODE_TWO_TRACKS);

        $this->assertGreaterThan(100, strlen($result));
    }

}