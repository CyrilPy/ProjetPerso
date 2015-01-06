//
//  Acceuil.swift
//  Seen
//
//  Created by Cyril Py on 05/01/2015.
//  Copyright (c) 2015 Cyril Py. All rights reserved.
//

import UIKit
import Foundation

class Acceuil: UIViewController {
    
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view, typically from a nib.
        lrechercher.text = "Rechercher";
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    @IBOutlet weak var rechercher: UITableViewCell!
    @IBOutlet weak var films: UITableViewCell!
    @IBOutlet weak var series: UITableViewCell!
    @IBOutlet weak var compte: UITableViewCell!
    
    @IBOutlet weak var lrechercher: UILabel!
    
    
}
