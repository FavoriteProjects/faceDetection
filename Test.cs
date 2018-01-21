using System;
using System.Net.Http.Headers;
using System.Text;
using System.Net.Http;
using System.Web;
using Microsoft.ProjectOxford.Face;
using Microsoft.ProjectOxford.Face.Contract;
using System.IO;
using System.Threading.Tasks;
using System.Linq;

namespace BasicConsoleSample
{
    public class Test
    {
        public static object HttpUtility { get; private set; }

        public async void MakeRequest()
        {
            FaceServiceClient faceServiceClient = new FaceServiceClient("84480b5a271e474f8258ac38eff96a71", "https://westcentralus.api.cognitive.microsoft.com/face/v1.0");
            string personGroupId = "criminals";
            //await faceServiceClient.CreatePersonGroupAsync(personGroupId, "criminals");
            // Define Braja
            CreatePersonResult c1 = await faceServiceClient.CreatePersonAsync(
                // Id of the person group that the person belonged to
                personGroupId,
                // Name of the person
                "Braja"
            );

            const string friend1ImageDir = @"F:\Entertainment\IMAGES\bgm\";

            foreach (string imagePath in Directory.GetFiles(friend1ImageDir, "*.jpg"))
            {
                using (Stream s = File.OpenRead(imagePath))
                {
                    // Detect faces in the image and add to Anna
                    await faceServiceClient.AddPersonFaceAsync(
                        personGroupId, c1.PersonId, s);
                }
            }

            await faceServiceClient.TrainPersonGroupAsync(personGroupId);
            Console.WriteLine("**********************Training has started*****************************");
            TrainingStatus trainingStatus = null;
            while (true)
            {
                trainingStatus = await faceServiceClient.GetPersonGroupTrainingStatusAsync(personGroupId);

                if (trainingStatus.Status != Status.Running)
                {
                    break;
                }

                await Task.Delay(1000);
            }
            Console.WriteLine("**********************Training has been finished*****************************");


            string testImageFile = @"F:\Entertainment\test.jpg";

            using (Stream s = File.OpenRead(testImageFile))
            {
                var faces = await faceServiceClient.DetectAsync(s);
                var faceIds = faces.Select(face => face.FaceId).ToArray();

                var results = await faceServiceClient.IdentifyAsync(personGroupId, faceIds);
                foreach (var identifyResult in results)
                {
                    Console.WriteLine("Result of face: {0}", identifyResult.FaceId);
                    if (identifyResult.Candidates.Length == 0)
                    {
                        Console.WriteLine("No one identified");
                    }
                    else
                    {
                        // Get top 1 among all candidates returned
                        var candidateId = identifyResult.Candidates[0].PersonId;
                        var person = await faceServiceClient.GetPersonAsync(personGroupId, candidateId);
                        Console.WriteLine("==============>Identified as {0}", person.Name);
                    }
                }
            }
        }
    }
}