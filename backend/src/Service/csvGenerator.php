<?php
    namespace App\Service;


    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Serializer\Encoder\CsvEncoder;
    use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
    use Symfony\Component\Serializer\Serializer;

    class csvGenerator{




        public function export($data, $filename)
        {
            $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
            $response = new Response($serializer->encode($data, CsvEncoder::FORMAT));
            $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
            $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");
            return $response;
        }




    }
