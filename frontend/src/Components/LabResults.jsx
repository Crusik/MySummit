import React from 'react';
// import SimpleBar from 'simplebar-react';
// import 'simplebar-react/dist/simplebar.min.css';
// import { FaFileDownload } from "react-icons/fa";

function LabResults({ patients, activePatientId }) {
//   const selectedPatient = patients[activePatientId];

//   if (!selectedPatient) {
//     return (
//       <div className='Lab-Results'>
//         <h3 className='Card-Headers'>Lab Results</h3>
//         <SimpleBar
//           style={{ maxHeight: '178px', width: '100%' }}
//           className='Lab-Results-Section'
//         >
//           <div className='Results'>
//             <div className='Result-Item'>
//               <span>No patient selected</span>
//             </div>
//           </div>
//         </SimpleBar>
//       </div>
//     );
//   }

  return (
    <div className='Lab-Results'>
        <p>View your lab results and reports here.</p>
      {/* <h3 className='Card-Headers'>Lab Results</h3>
      <SimpleBar
        style={{ maxHeight: '178px', width: '100%' }}
        className='Lab-Results-Section'
      >
        <div className='Results'>
          {selectedPatient.lab_results?.map((result, index) => (
            <div key={index} className='Result-Item'>
              <span>{result}</span>
              <FaFileDownload className="Download-Icon" alt={`Download ${result}`} />
            </div>
          ))}
        </div>
      </SimpleBar> */}
    </div>
  );
}
export default LabResults;
